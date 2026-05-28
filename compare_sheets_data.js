import xlsx from 'xlsx';

const filePath = './RBI 2025 all.xlsx';
try {
    const workbook = xlsx.readFile(filePath);
    
    // Read Sheet3
    const sheet3 = workbook.Sheets['Sheet3'];
    const data3 = xlsx.utils.sheet_to_json(sheet3, { header: 1 });
    
    const purokSheets = ['purok 1', 'purok 2', 'purok 3', 'purok 4', 'purok 5', 'purok 6', 'purok 7', 'purok 8'];
    
    purokSheets.forEach(purokSheet => {
        const worksheet = workbook.Sheets[purokSheet];
        const dataPurok = xlsx.utils.sheet_to_json(worksheet, { header: 1 });
        
        // Find header row for this purok
        let headerRowIdx = -1;
        for (let r = 0; r < Math.min(15, dataPurok.length); r++) {
            const row = dataPurok[r] || [];
            const hasLastName = row.some(cell => cell && typeof cell === 'string' && (cell.toLowerCase().includes('last name') || cell.toLowerCase().includes('family name')));
            const hasFirstName = row.some(cell => cell && typeof cell === 'string' && cell.toLowerCase().includes('first name'));
            if (hasLastName && hasFirstName) {
                headerRowIdx = r;
                break;
            }
        }
        
        if (headerRowIdx !== -1) {
            const headers = dataPurok[headerRowIdx];
            const lastNameIdx = headers.findIndex(cell => cell && typeof cell === 'string' && (cell.toLowerCase().includes('last name') || cell.toLowerCase().includes('family name')));
            const firstNameIdx = headers.findIndex(cell => cell && typeof cell === 'string' && cell.toLowerCase().includes('first name'));
            
            // Get first resident of this purok sheet
            let firstResident = null;
            for (let r = headerRowIdx + 1; r < dataPurok.length; r++) {
                const row = dataPurok[r];
                if (row && (row[lastNameIdx] || row[firstNameIdx])) {
                    firstResident = {
                        lastName: String(row[lastNameIdx] || "").trim(),
                        firstName: String(row[firstNameIdx] || "").trim()
                    };
                    break;
                }
            }
            
            if (firstResident) {
                // Find this resident in Sheet3 (let's assume column 7 is Last Name, column 8 is First Name in Sheet3)
                let foundIndex = -1;
                for (let r = 9; r < data3.length; r++) {
                    const r3 = data3[r];
                    if (r3 && String(r3[7] || "").trim().toLowerCase() === firstResident.lastName.toLowerCase() &&
                        String(r3[8] || "").trim().toLowerCase() === firstResident.firstName.toLowerCase()) {
                        foundIndex = r;
                        break;
                    }
                }
                console.log(`Purok Sheet: "${purokSheet}" | First Resident: "${firstResident.firstName} ${firstResident.lastName}" | Found in Sheet3 at Row: ${foundIndex}`);
            } else {
                console.log(`Purok Sheet: "${purokSheet}" | No residents found`);
            }
        }
    });
} catch (error) {
    console.error("Error:", error.message);
}
