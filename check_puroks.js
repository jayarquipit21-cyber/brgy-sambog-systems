import xlsx from 'xlsx';

const filePath = './RBI 2025 all.xlsx';
try {
    const workbook = xlsx.readFile(filePath);
    console.log("Sheet names in workbook:", workbook.SheetNames);
    
    workbook.SheetNames.forEach(sheetName => {
        const worksheet = workbook.Sheets[sheetName];
        const jsonData = xlsx.utils.sheet_to_json(worksheet, { header: 1 });
        
        // check row count and look at row 8 (header)
        const row8 = jsonData[8];
        const row0 = jsonData[0] || [];
        const row1 = jsonData[1] || [];
        
        console.log(`\nSheet: "${sheetName}" | Rows: ${jsonData.length}`);
        
        // find Purok info in top rows
        let purokInfo = "";
        for (let r = 0; r < 8; r++) {
            const rowText = (jsonData[r] || []).map(c => String(c)).join(" ");
            if (rowText.includes("Purok")) {
                purokInfo += ` | Row ${r}: ${rowText.replace(/\s+/g, ' ').substring(0, 80)}`;
            }
        }
        console.log(`  Purok Info: ${purokInfo || "None found"}`);
        
        if (row8) {
            const hasFamilyName = row8.some(cell => typeof cell === 'string' && cell.toLowerCase().includes('family name') || cell.toLowerCase().includes('last name'));
            console.log(`  Row 8 has resident headers? ${hasFamilyName ? "YES" : "NO"}`);
            if (hasFamilyName) {
                // Check a few non-empty rows of data starting at row 9
                let dataRowsCount = 0;
                for (let r = 9; r < jsonData.length; r++) {
                    const row = jsonData[r];
                    // if last name or first name exists, count as a data row
                    if (row && (row[7] || row[8])) {
                        dataRowsCount++;
                    }
                }
                console.log(`  Total valid data rows: ${dataRowsCount}`);
            }
        }
    });
} catch (error) {
    console.error("Error:", error.message);
}
