import xlsx from 'xlsx';

const filePath = './RBI 2025 all.xlsx';
try {
    const workbook = xlsx.readFile(filePath);
    const sheets = ['purok 1', 'purok 2', 'purok 3', 'purok 4', 'purok 5', 'purok 6', 'purok 7', 'purok 8', 'Sheet3'];
    
    sheets.forEach(sheetName => {
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
        
        if (headerRowIdx !== -1) {
            const headers = jsonData[headerRowIdx];
            const lastNameIdx = headers.findIndex(cell => cell && typeof cell === 'string' && (cell.toLowerCase().includes('last name') || cell.toLowerCase().includes('family name')));
            const firstNameIdx = headers.findIndex(cell => cell && typeof cell === 'string' && cell.toLowerCase().includes('first name'));
            const bdateIdx = headers.findIndex(cell => cell && typeof cell === 'string' && cell.toLowerCase().includes('birthdate'));
            const emailIdx = headers.findIndex(cell => cell && typeof cell === 'string' && cell.toLowerCase().includes('email'));
            const mobileIdx = headers.findIndex(cell => cell && typeof cell === 'string' && cell.toLowerCase().includes('mobile'));
            
            console.log(`Sheet: "${sheetName}" | Header Row: ${headerRowIdx}`);
            console.log(`  LastName Col: ${lastNameIdx} | FirstName Col: ${firstNameIdx} | Birthdate Col: ${bdateIdx} | Email Col: ${emailIdx} | Mobile Col: ${mobileIdx}`);
        } else {
            console.log(`Sheet: "${sheetName}" | No headers found`);
        }
    });
} catch (error) {
    console.error("Error:", error.message);
}
