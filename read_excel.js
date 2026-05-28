import xlsx from 'xlsx';

const filePath = './RBI 2025 all.xlsx';
try {
    const workbook = xlsx.readFile(filePath);
    console.log("Sheets in workbook:", workbook.SheetNames);
    
    workbook.SheetNames.forEach(sheetName => {
        const worksheet = workbook.Sheets[sheetName];
        const jsonData = xlsx.utils.sheet_to_json(worksheet, { header: 1 });
        
        console.log(`\n--- Sheet: ${sheetName} ---`);
        if (jsonData.length > 0) {
            console.log("Headers:", jsonData[0]);
            console.log("Sample Row 1:", jsonData[1] || "None");
            console.log("Sample Row 2:", jsonData[2] || "None");
        } else {
            console.log("Sheet is empty");
        }
    });
} catch (error) {
    console.error("Error reading file:", error.message);
}
