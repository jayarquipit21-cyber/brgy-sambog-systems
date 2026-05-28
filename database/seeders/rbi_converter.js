import xlsx from 'xlsx';
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const filePath = path.resolve(__dirname, '../../RBI 2025 all.xlsx');
const outputJsonPath = path.resolve(__dirname, 'rbi_data.json');

// Excel serial date to YYYY-MM-DD
function parseExcelDate(val) {
    if (!val) return null;
    if (typeof val === 'number') {
        // Excel leap year bug means we subtract 1 if serial is greater than 59
        let serial = val;
        let date = new Date((serial - 25569) * 86400 * 1000);
        if (isNaN(date.getTime())) return String(val);
        return date.toISOString().split('T')[0];
    }
    
    const str = String(val).trim();
    if (/^\d{4}-\d{2}-\d{2}$/.test(str)) {
        return str;
    }
    
    // Attempt parsing common formats if possible, otherwise return as-is
    const parsed = Date.parse(str);
    if (!isNaN(parsed)) {
        return new Date(parsed).toISOString().split('T')[0];
    }
    return str;
}

try {
    console.log(`Reading Excel file: ${filePath}`);
    const workbook = xlsx.readFile(filePath);
    
    const purokSheets = ['purok 1', 'purok 2', 'purok 3', 'purok 4', 'purok 5', 'purok 6', 'purok 7', 'purok 8'];
    const households = [];
    const residents = [];
    
    let householdGlobalCount = 0;
    
    purokSheets.forEach(sheetName => {
        const worksheet = workbook.Sheets[sheetName];
        if (!worksheet) {
            console.warn(`Warning: Sheet ${sheetName} not found.`);
            return;
        }
        
        const jsonData = xlsx.utils.sheet_to_json(worksheet, { header: 1 });
        const purokNo = sheetName.replace('purok ', '').trim();
        
        // Find header row index
        let headerRowIdx = -1;
        for (let r = 0; r < Math.min(15, jsonData.length); r++) {
            const row = jsonData[r] || [];
            const hasLastName = row.some(cell => cell && typeof cell === 'string' && (cell.toLowerCase().includes('last name') || cell.toLowerCase().includes('family name')));
            const hasFirstName = row.some(cell => cell && typeof cell === 'string' && cell.toLowerCase().includes('first name'));
            if (hasLastName && hasFirstName) {
                headerRowIdx = r;
                break;
            }
        }
        
        // Special case for purok 4
        if (headerRowIdx === -1 && sheetName === 'purok 4') {
            headerRowIdx = 3;
        }
        
        if (headerRowIdx === -1) {
            console.error(`Error: Could not find header row for ${sheetName}`);
            return;
        }
        
        console.log(`Processing ${sheetName} starting at row ${headerRowIdx + 1}`);
        
        let currentHouseholdNo = null;
        let currentHouseholdIdx = -1;
        
        for (let r = headerRowIdx + 1; r < jsonData.length; r++) {
            const row = jsonData[r];
            if (!row) continue;
            
            // Check if this row is valid resident row (has either last name or first name)
            // Last Name is Col 7, First Name is Col 8
            const lastNameVal = row[7] ? String(row[7]).trim() : '';
            const firstNameVal = row[8] ? String(row[8]).trim() : '';
            
            if (!lastNameVal && !firstNameVal) {
                // Skip empty rows
                continue;
            }
            
            const householdNoVal = row[1] ? String(row[1]).trim() : '';
            const isHead = (row[3] ? String(row[3]).trim().toLowerCase() : '') === 'hh' || (row[3] ? String(row[3]).trim().toLowerCase() : '') === 'household head';
            
            // If we find a new household number or if it's the first resident on the sheet, or if isHead and householdNoVal is empty but we need to start a new household
            if (householdNoVal || isHead || currentHouseholdIdx === -1) {
                const newHouseholdNo = householdNoVal || currentHouseholdNo || `P${purokNo}-H${householdGlobalCount + 1}`;
                
                // If it's a new household number or we don't have one yet
                if (newHouseholdNo !== currentHouseholdNo || currentHouseholdIdx === -1) {
                    currentHouseholdNo = newHouseholdNo;
                    householdGlobalCount++;
                    
                    households.push({
                        id: householdGlobalCount,
                        household_no: currentHouseholdNo,
                        purok_no: purokNo,
                        address: `Purok ${purokNo}, Barangay Corella`
                    });
                    currentHouseholdIdx = households.length - 1;
                }
            }
            
            // Map resident columns
            const resident = {
                household_id: households[currentHouseholdIdx].id,
                population_no: row[0] ? String(row[0]).trim() : null,
                family_no: row[2] ? String(row[2]).trim() : null,
                relationship_to_head: row[3] ? String(row[3]).trim() : null,
                is_house_owner: row[4] ? String(row[4]).trim() : null,
                is_renter: row[5] ? String(row[5]).trim() : null,
                renter_months: row[6] ? String(row[6]).trim() : null,
                last_name: lastNameVal,
                first_name: firstNameVal,
                middle_name: row[9] ? String(row[9]).trim() : null,
                extension: row[10] ? String(row[10]).trim() : null,
                birthdate: parseExcelDate(row[11]),
                place_of_birth: row[12] ? String(row[12]).trim() : null,
                sex: row[13] ? String(row[13]).trim() : null,
                gender_identity: row[14] ? String(row[14]).trim() : null,
                civil_status: row[15] ? String(row[15]).trim() : null,
                religion: row[16] ? String(row[16]).trim() : null,
                citizenship: row[17] ? String(row[17]).trim() : null,
                age: row[18] ? parseInt(row[18]) : null,
                age_classification: row[19] ? String(row[19]).trim() : null,
                blood_type: row[20] ? String(row[20]).trim() : null,
                height: row[21] ? String(row[21]).trim() : null,
                weight: row[22] ? String(row[22]).trim() : null,
                complexion: row[23] ? String(row[23]).trim() : null,
                mobile_number: row[24] ? String(row[24]).trim() : null,
                email_address: row[25] ? String(row[25]).trim() : null,
                social_media_account: row[26] ? String(row[26]).trim() : null,
                
                educational_status: row[27] ? String(row[27]).trim() : null,
                highest_educational_attainment: row[28] ? String(row[28]).trim() : null,
                school_attended: row[29] ? String(row[29]).trim() : null,
                course_completed: row[30] ? String(row[30]).trim() : null,
                eligibility: row[31] ? String(row[31]).trim() : null,
                primary_skills: row[32] ? String(row[32]).trim() : null,
                secondary_skills: row[33] ? String(row[33]).trim() : null,
                other_skills: row[34] ? String(row[34]).trim() : null,
                
                work_status: row[35] ? String(row[35]).trim() : null,
                occupation: row[36] ? String(row[36]).trim() : null,
                is_farmer: row[37] ? String(row[37]).trim() : null,
                income: row[38] ? String(row[38]).trim() : null,
                days_work_per_week: row[39] ? String(row[39]).trim() : null,
                last_period_of_unemployment: row[40] ? String(row[40]).trim() : null,
                reason_of_unemployment: row[41] ? String(row[41]).trim() : null,
                
                registered_sk_voter: row[42] ? String(row[42]).trim() : null,
                registered_national_voter: row[43] ? String(row[43]).trim() : null,
                attended_kk_assembly: row[44] ? String(row[44]).trim() : null,
                kk_assembly_times: row[45] ? String(row[45]).trim() : null,
                kk_assembly_no_reason: row[46] ? String(row[46]).trim() : null,
                resident_voter: row[47] ? String(row[47]).trim() : null,
                last_voted_year: row[48] ? String(row[48]).trim() : null,
                
                has_philhealth: row[49] ? String(row[49]).trim() : null,
                philhealth_id: row[50] ? String(row[50]).trim() : null,
                philhealth_membership_type: row[51] ? String(row[51]).trim() : null,
                unvaccinated: row[52] ? String(row[52]).trim() : null,
                partially_vaccinated: row[53] ? String(row[53]).trim() : null,
                fully_vaccinated: row[54] ? String(row[54]).trim() : null,
                covid_dose_1_date: parseExcelDate(row[55]),
                covid_dose_2_date: parseExcelDate(row[56]),
                covid_brand: row[57] ? String(row[57]).trim() : null,
                has_booster: row[58] ? String(row[58]).trim() : null,
                booster_date: parseExcelDate(row[59]),
                booster_brand: row[60] ? String(row[60]).trim() : null,
                
                health_condition: row[61] ? String(row[61]).trim() : null,
                nutritional_classification: row[62] ? String(row[62]).trim() : null,
                vulnerable_sector: row[63] ? String(row[63]).trim() : null,
                social_welfare_availed: row[64] ? String(row[64]).trim() : null,
                
                water_source: row[65] ? String(row[65]).trim() : null,
                sanitary_toilet: row[66] ? String(row[66]).trim() : null,
                waste_management: row[67] ? String(row[67]).trim() : null,
                has_blind_drainage: row[68] ? String(row[68]).trim() : null
            };
            
            residents.push(resident);
        }
    });
    
    console.log(`Successfully parsed:`);
    console.log(`  - Households: ${households.length}`);
    console.log(`  - Residents: ${residents.length}`);
    
    const outputData = {
        households,
        residents
    };
    
    fs.writeFileSync(outputJsonPath, JSON.stringify(outputData, null, 2), 'utf-8');
    console.log(`JSON written to: ${outputJsonPath}`);
    
} catch (error) {
    console.error("Error running converter:", error);
}
