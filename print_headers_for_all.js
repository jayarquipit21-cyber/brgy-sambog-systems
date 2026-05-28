import xlsx from 'xlsx';

const filePath = './RBI 2025 all.xlsx';
try {
    const workbook = xlsx.readFile(filePath);
    const sheets = ['purok 1', 'purok 2', 'purok 3', 'purok 4', 'purok 5', 'purok 6', 'purok 7', 'purok 8'];
    
    sheets.forEach(sheetName => {
        const worksheet = workbook.Sheets[sheetName];
        const jsonData = xlsx.utils.sheet_to_json(worksheet, { header: 1 });
        
        // Find header row
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
            const headers = jsonData[headerRowIdx].map(cell => cell ? String(cell).trim().replace(/\s+/g, ' ') : 'NULL');
            console.log(`Sheet: ${sheetName} | Header Row Index: ${headerRowIdx} | Total Columns: ${headers.length}`);
            console.log(`  First 5 columns: ${headers.slice(0, 5).join(" | ")}`);
            console.log(`  Last 3 columns: ${headers.slice(-3).join(" | ")}`);
        } else {
            console.log(`Sheet: ${sheetName} | NO HEADERS FOUND`);
        }
    });
} catch (error) {
    console.error("Error:", error.message);
}
