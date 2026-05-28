import xlsx from 'xlsx';

const filePath = './RBI 2025 all.xlsx';
try {
    const workbook = xlsx.readFile(filePath);
    const worksheet = workbook.Sheets['purok 4'];
    const jsonData = xlsx.utils.sheet_to_json(worksheet, { header: 1 });
    
    const headers = jsonData[3]; // Row 3
    for (let i = 0; i < 15; i++) {
        console.log(`Col ${i}: "${headers[i]}"`);
    }
} catch (error) {
    console.error("Error:", error.message);
}
