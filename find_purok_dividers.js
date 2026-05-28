import xlsx from 'xlsx';

const filePath = './RBI 2025 all.xlsx';
try {
    const workbook = xlsx.readFile(filePath);
    const sheet3 = workbook.Sheets['Sheet3'];
    const data3 = xlsx.utils.sheet_to_json(sheet3, { header: 1 });
    
    console.log("Total rows in Sheet3:", data3.length);
    
    // Search for rows that might be dividers
    let dividers = [];
    for (let r = 9; r < data3.length; r++) {
        const row = data3[r];
        if (!row || row.length === 0) continue;
        
        // If a row is mostly empty, but has text like "Purok" or "Purok 2"
        const nonNulls = row.filter(c => c !== null && c !== undefined && String(c).trim() !== "");
        if (nonNulls.length > 0 && nonNulls.length < 5) {
            const text = nonNulls.join(" ");
            if (text.toLowerCase().includes("purok") || text.toLowerCase().includes("registry")) {
                dividers.push({ index: r, text });
            }
        }
    }
    
    console.log("Found dividers in Sheet3:");
    dividers.forEach(d => {
        console.log(`Row ${d.index}: "${d.text}"`);
    });
} catch (error) {
    console.error("Error:", error.message);
}
