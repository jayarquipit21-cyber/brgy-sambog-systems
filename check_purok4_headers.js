import xlsx from 'xlsx';

const filePath = './RBI 2025 all.xlsx';
try {
    const workbook = xlsx.readFile(filePath);
    const worksheet = workbook.Sheets['purok 4'];
    const jsonData = xlsx.utils.sheet_to_json(worksheet, { header: 1 });
    
    for (let r = 4; r <= 8; r++) {
        const row = jsonData[r];
        console.log(`\n--- Row ${r} ---`);
        for (let idx = 0; idx <= 12; idx++) {
            const cell = row ? row[idx] : undefined;
            console.log(`Col ${idx}: "${cell ? String(cell).trim().replace(/\s+/g, ' ') : ''}"`);
        }
    }
} catch (error) {
    console.error("Error:", error.message);
}
