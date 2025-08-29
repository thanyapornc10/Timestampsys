// เพิ่มการตรวจสอบเหตุผลที่เลือกและแบบฟอร์มแจ้งเตือน
document.getElementById("attendance-form").addEventListener("submit", function (e) {
  e.preventDefault();

  let timedate = document.getElementById("timedate").value;
  let time_in = document.getElementById("time_in").value;
  let reason = document.getElementById("reason").value;

  // เช็คถ้าในแบบฟอร์มมีข้อมูล
  if (timedate && time_in && reason) {
    // ดำเนินการบันทึกข้อมูลลงในฐานข้อมูลโดยใช้ AJAX หรือ fetch API
    // หลังจากบันทึกเรียบร้อยแสดงข้อความว่าบันทึกสำเร็จ
    alert("บันทึกเวลาสำเร็จ");
  } else {
    alert("กรุณากรอกข้อมูลให้ครบถ้วน");
  }
});
