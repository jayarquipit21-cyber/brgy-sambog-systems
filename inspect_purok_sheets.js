import xlsx from 'xlsx';

const filePath = './RBI 2025 all.xlsx';
try {
    const workbook = xlsx.readFile(filePath);
    
    workbook.SheetNames.forEach(sheetName => {
        const worksheet = workbook.Sheets[sheetName];
        const jsonData = xlsx.utils.sheet_to_json(worksheet, { header: 1 });
        
        console.log(`\nSheet: "${sheetName}" | Rows: ${jsonData.length}`);
        
        // Find Purok Info in first 8 rows
        let purokNo = "";
        let purokName = "";
        for (let r = 0; r < 8; r++) {
            const row = jsonData[r] || [];
            row.forEach((cell, idx) => {
                if (cell && typeof cell === 'string') {
                    if (cell.includes("Purok No.:")) {
                        purokNo = String(row[idx + 1] || row[idx + 2] || "").trim();
                    }
                    if (cell.includes("Purok Name:")) {
                        purokName = String(row[idx + 1] || row[idx + 2] || "").trim();
                    }
                }
            });
        }
        console.log(`  Extracted: Purok No = "${purokNo}", Purok Name = "${purokName}"`);
        
        // Scan for header row index (which contains FAMILY NAME / LAST NAME and FIRST NAME)
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
        
        if (headerRowIdx !== -1) {
            console.log(`  Resident headers found at Row Index ${headerRowIdx}`);
            let validDataRows = 0;
            const headers = jsonData[headerRowIdx];
            const lastNameIdx = headers.findIndex(cell => cell && typeof cell === 'string' && (cell.toLowerCase().includes('last name') || cell.toLowerCase().includes('family name')));
            const firstNameIdx = headers.findIndex(cell => cell && typeof cell === 'string' && cell.toLowerCase().includes('first name'));
            
            for (let r = headerRowIdx + 1; r < jsonData.length; r++) {
                const row = jsonData[r];
                if (row && (row[lastNameIdx] || row[firstNameIdx])) {
                    validDataRows++;
                }
            }
            console.log(`  Total valid data rows: ${validDataRows}`);
        } else {
            console.log(`  No resident headers found!`);
        }
    });
} catch (error) {
    console.error("Error:", error.message);
}
