import xlsx from 'xlsx';

const filePath = './RBI 2025 all.xlsx';
try {
    const workbook = xlsx.readFile(filePath);
    
    workbook.SheetNames.forEach(sheetName => {
        const worksheet = workbook.Sheets[sheetName];
        const jsonData = xlsx.utils.sheet_to_json(worksheet, { header: 1 });
        
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
        
        // Let's also fallback for purok 4 where column 7 is blank in header but column 8 has "First Name"
        if (headerRowIdx === -1 && sheetName === 'purok 4') {
            headerRowIdx = 3;
        }
        
        if (headerRowIdx !== -1) {
            let dataRowsCount = 0;
            // Let's assume Column 8 is always First Name (or search for First Name)
            const headers = jsonData[headerRowIdx];
            const firstNameIdx = headers.findIndex(cell => cell && typeof cell === 'string' && cell.toLowerCase().includes('first name')) !== -1 
                ? headers.findIndex(cell => cell && typeof cell === 'string' && cell.toLowerCase().includes('first name')) 
                : 8;
            
            const lastNameIdx = sheetName === 'purok 4' ? 7 : (headers.findIndex(cell => cell && typeof cell === 'string' && (cell.toLowerCase().includes('last name') || cell.toLowerCase().includes('family name'))) !== -1
                ? headers.findIndex(cell => cell && typeof cell === 'string' && (cell.toLowerCase().includes('last name') || cell.toLowerCase().includes('family name')))
                : 7);
            
            for (let r = headerRowIdx + 1; r < jsonData.length; r++) {
                const row = jsonData[r];
                if (row && (row[lastNameIdx] || row[firstNameIdx])) {
                    dataRowsCount++;
                }
            }
            console.log(`Sheet: "${sheetName}" | Header Row: ${headerRowIdx} | Valid Data Rows: ${dataRowsCount}`);
        } else {
            console.log(`Sheet: "${sheetName}" | No resident headers found`);
        }
    });
} catch (error) {
    console.error("Error:", error.message);
}
