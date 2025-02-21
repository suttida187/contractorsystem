"use strict";

// Setting Color

$(window).resize(function () {
  $(window).width();
});

getCheckmark();

$(".changeBodyBackgroundFullColor").on("click", function () {
  if ($(this).attr("data-color") == "default") {
    $("body").removeAttr("data-background-full");
  } else {
    $("body").attr("data-background-full", $(this).attr("data-color"));
  }

  $(this).parent().find(".changeBodyBackgroundFullColor").removeClass("selected");
  $(this).addClass("selected");
  layoutsColors();
  getCheckmark();
});

$(".changeLogoHeaderColor").on("click", function () {
  if ($(this).attr("data-color") == "default") {
    $(".logo-header").removeAttr("data-background-color");
  } else {
    $(".logo-header").attr("data-background-color", $(this).attr("data-color"));
  }

  $(this).parent().find(".changeLogoHeaderColor").removeClass("selected");
  $(this).addClass("selected");
  customCheckColor();
  layoutsColors();
  getCheckmark();
});

$(".changeTopBarColor").on("click", function () {
  if ($(this).attr("data-color") == "default") {
    $(".main-header .navbar-header").removeAttr("data-background-color");
  } else {
    $(".main-header .navbar-header").attr("data-background-color", $(this).attr("data-color"));
  }

  $(this).parent().find(".changeTopBarColor").removeClass("selected");
  $(this).addClass("selected");
  layoutsColors();
  getCheckmark();
});

$(".changeSideBarColor").on("click", function () {
  if ($(this).attr("data-color") == "default") {
    $(".sidebar").removeAttr("data-background-color");
  } else {
    $(".sidebar").attr("data-background-color", $(this).attr("data-color"));
  }

  $(this).parent().find(".changeSideBarColor").removeClass("selected");
  $(this).addClass("selected");
  layoutsColors();
  getCheckmark();
});

$(".changeBackgroundColor").on("click", function () {
  $("body").removeAttr("data-background-color");
  $("body").attr("data-background-color", $(this).attr("data-color"));
  $(this).parent().find(".changeBackgroundColor").removeClass("selected");
  $(this).addClass("selected");
  getCheckmark();
});

function customCheckColor() {
  var logoHeader = $(".logo-header").attr("data-background-color");
  if (logoHeader !== "white") {
    $(".logo-header .navbar-brand").attr("src", "assets/img/kaiadmin/logo_light.svg");
  } else {
    $(".logo-header .navbar-brand").attr("src", "assets/img/kaiadmin/logo_dark.svg");
  }
}

var toggle_customSidebar = false,
  custom_open = 0;

if (!toggle_customSidebar) {
  var toggle = $(".custom-template .custom-toggle");

  toggle.on("click", function () {
    if (custom_open == 1) {
      $(".custom-template").removeClass("open");
      toggle.removeClass("toggled");
      custom_open = 0;
    } else {
      $(".custom-template").addClass("open");
      toggle.addClass("toggled");
      custom_open = 1;
    }
  });
  toggle_customSidebar = true;
}

function getCheckmark() {
  var checkmark = `<i class="gg-check"></i>`;
  $(".btnSwitch").find("button").empty();
  $(".btnSwitch").find("button.selected").append(checkmark);
}



document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".icon-action.delete").forEach(function (btn) {
    btn.addEventListener("click", function (event) {
      event.preventDefault(); // ป้องกันไม่ให้ลิงก์ทำงานทันที

      let userEmail = this.getAttribute("data-email");
      let userId = this.getAttribute("data-user-id");



      Swal.fire({
        title: "คุณแน่ใจหรือไม่?",
        text: `คุณต้องการลบผู้ใช้ที่มีอีเมล ${userEmail} ใช่หรือไม่?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "ใช่, ลบเลย!",
        cancelButtonText: "ยกเลิก"
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `delete-user/${userId}`;
        }
      });
    });
  });
});


function fetchNotifications() {
  $.ajax({
    url: "notifications-fetch", // ดึงข้อมูลจาก Route
    type: "GET",
    success: function (data) {
      let notificationDropdown = $("#notif-center");
      let notificationCount = $(".notification");
      let notifCountText = $("#notif-count");

      notificationDropdown.empty(); // ล้างรายการเดิม

      if (data.length > 0) {
        notificationCount.text(data.length).show(); // แสดงจำนวนแจ้งเตือน
        notifCountText.text(data.length);

        data.forEach(notification => {
          let notifItem = `
            <a href="${notification.url}">
                <div class="notif-icon notif-primary" style="width: 40px; height:40px">
                    <i class="fa fa-project-diagram" style="font-size: 16px;"></i>
                </div>
                <div class="notif-content">
                    <span class="block">${notification.message}</span>
                    <span class="time">${notification.time}</span>
                </div>
            </a>
        `;

          notificationDropdown.append(notifItem);
        });
      } else {
        notificationCount.hide();
        notifCountText.text(0);
        notificationDropdown.append(`<p class="text-center p-2">ไม่มีการแจ้งเตือนใหม่</p>`);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error fetching notifications:", error);
    }
  });
}


function userDataFuc(userData) {


  if (userData.status == null) {
    document.getElementById("stepStatusNull").style.display = "contents";
    document.getElementById("stepStatus").style.display = "none";
  } else {
    document.getElementById("stepStatusNull").style.display = "none";
    document.getElementById("stepStatus").style.display = "contents";
  }
  // ใส่ข้อมูลลงใน Modal



  // เติมค่าลงใน Modal
  document.getElementById("project_id").value = userData.id || "";
  document.getElementById("project_name").value = userData.project_name || "";
  document.getElementById("work_type").value = userData.work_type || "";
  document.getElementById("solution").value = userData.solution || "";
  document.getElementById("work_description").value = userData.work_description ||
    "";
  document.getElementById("meeting_date").value = userData.meeting_date || "";
  document.getElementById("meeting_time").value = userData.meeting_time || "";
  document.getElementById("end_date").value = userData.end_date || "";
  document.getElementById("company_name").value = userData.company_name || "";
  document.getElementById("contact_name").value = userData.contact_name || "";
  document.getElementById("contact_phone").value = userData.contact_phone || "";
  document.getElementById("contact_position").value = userData.contact_position ||
    "";
  document.getElementById("location").value = userData.location || "";

  if (userData.solution == 'Other') {
    document.getElementById("otherSolutionDiv").classList.remove("d-none");
    document.getElementById("other_solution").value = userData.other_solution || "";
  } else {
    document.getElementById("otherSolutionDiv") && document.getElementById("otherSolutionDiv").classList.add("d-none");
  }
  if (userData.work_type == 'Other') {
    document.getElementById("otherWork_typeDiv").classList.remove("d-none");
    document.getElementById("other_work_type").value = userData.other_work_type || "";
  } else {
    document.getElementById("otherWork_typeDiv") && document.getElementById("otherWork_typeDiv").classList.add("d-none");
  }

  var locationLink = document.getElementById("location_link");
  if (userData.location) {
    locationLink.href = userData.location;
    locationLink.classList.remove("d-none"); // แสดงลิงก์
  } else {
    locationLink.classList.add("d-none"); // ซ่อนลิงก์ถ้าไม่มีค่า
  }


  document.getElementById("warranty").value = userData.warranty || "";
  document.getElementById("additional_notes").value = userData.additional_notes ||
    "";
  document.getElementById("needs_documents").value = userData.needs_documents ||
    "";


  document.getElementById("caretaker_sale").value = (userData.sale_prefix ? userData.sale_prefix : '') + ' ' +
    (userData.sale_first_name ? userData.sale_first_name : '') + ' ' +
    (userData.sale_last_name ? userData.sale_last_name : '')
  document.getElementById("caretaker_sale_phone").value = userData.sale_phone ||
    "";


  document.getElementById("caretaker_admin").value = (userData.admin_prefix ? userData.admin_prefix : '') + ' ' +
    (userData.admin_first_name ? userData.admin_first_name : '') + ' ' +
    (userData.admin_last_name ? userData.admin_last_name : '')
  document.getElementById("caretaker_admin_phone").value = userData.admin_phone ||
    "";

  let fullName = '';

  if (userData.admin_prefix && userData.admin_prefix.trim() !== '') {
    fullName += userData.admin_prefix + ' ';
  }

  if (userData.admin_first_name && userData.admin_first_name.trim() !== '') {
    fullName += userData.admin_first_name;
  }

  fullName = fullName.trim(); // ตัดช่องว่างซ้าย-ขวาออก


  if (window.Laravel && window.Laravel.role && window.Laravel.role === 'admin') {
    if (fullName !== '') { // ตรวจสอบว่ามีค่าจริงๆ
      let managerSolution = document.getElementById("manager-solution");
      let managerButton = document.getElementById("manager-button");
      if (managerSolution) managerSolution.style.display = "none";
      if (managerButton) managerButton.style.display = "none";
    } else {
      let managerSolution = document.getElementById("manager-solution");
      let managerButton = document.getElementById("manager-button");
      if (managerSolution) managerSolution.style.display = "block";
      if (managerButton) managerButton.style.display = "block";
    }
  }







  document.getElementById("caretaker_pm").value = (userData.pm_prefix ? userData.pm_prefix : '') + ' ' +
    (userData.pm_first_name ? userData.pm_first_name : '') + ' ' +
    (userData.pm_last_name ? userData.pm_last_name : '');;
  document.getElementById("caretaker_pm_phone").value = userData.pm_phone || "";



  document.getElementById("caretaker_contractor").value = (userData.contractor_prefix ? userData.contractor_prefix : '') + ' ' +
    (userData.contractor_first_name ? userData.contractor_first_name : '') + ' ' +
    (userData.contractor_last_name ? userData.contractor_last_name : '');
  document.getElementById("caretaker_contractor_phone").value = userData
    .contractor_phone || "";


  let currentStep = 0;

  // ตรวจสอบว่า userData มีค่าหรือไม่
  if (userData.responsible_admin === null && userData.responsible_pm === null && userData.responsible_contractor === null) {
    currentStep = 1;
  } else if (
    userData.responsible_admin !== null &&
    userData.responsible_pm === null &&
    userData.responsible_contractor === null
  ) {
    currentStep = 2;
  } else if (
    userData.responsible_admin !== null &&
    userData.responsible_pm !== null &&
    userData.responsible_contractor === null
  ) {
    currentStep = 3;
  } else if (userData.responsible_contractor !== null) {
    currentStep = 4;
  }






  let progressContainer = document.getElementById("progress-container");

  // HTML Template สำหรับ Progress Bar
  let progressHTML = `
      <div class="progress-line-status step-1 ${currentStep >= 2 ? 'active' : 'dashed-line-status'}"></div>
      <div class="progress-line-status step-2 ${currentStep >= 3 ? 'active' : 'dashed-line-status'}"></div>
      <div class="progress-line-status step-3 ${currentStep >= 4 ? 'active' : 'dashed-line-status'}"></div>

      <!-- สเต็ป 1 -->
      <div class="text-center">
          <div class="progress-step-status ${currentStep >= 1 ? 'active' : ''}">1</div>
          <div class="progress-text-status">Sale กำลังดำเนินงาน</div>
      </div>

      <!-- สเต็ป 2 -->
      <div class="text-center">
          <div class="progress-step-status ${currentStep >= 2 ? 'active' : ''}">2</div>
          <div class="progress-text-status">รอ Admin ดำเนินการ</div>
      </div>

      <!-- สเต็ป 3 -->
      <div class="text-center">
          <div class="progress-step-status ${currentStep >= 3 ? 'active' : ''}">3</div>
          <div class="progress-text-status">รอ PM ดำเนินการ</div>
      </div>

      <!-- สเต็ป 4 -->
      <div class="text-center">
          <div class="progress-step-status ${currentStep >= 4 ? 'active' : ''}">4</div>
          <div class="progress-text-status">รอผู้รับเหมาดำเนินงาน</div>
      </div>
  `;

  // แทรก HTML ที่สร้างเข้าไปใน `progress-container`
  progressContainer.innerHTML = progressHTML;


  let progressContainerCheck = document.getElementById("progress-container-check");
  let currentStepCheck = 0;

  // ตรวจสอบว่า userData มีค่าหรือไม่
  if (userData.status == 'waiting_contractor') {
    currentStepCheck = 1;
  } else if (
    userData.status == 'waiting_pm_review'
  ) {
    currentStepCheck = 2;
  } else if (
    userData.status == 'waiting_admin_review'
  ) {
    currentStepCheck = 3;
  } else if (userData.status == 'completed') {
    currentStepCheck = 4;
  }

  let progress2HTML = `
  <!-- เส้น Progress -->
  <div class="progress-line-check step-1 ${currentStepCheck >= 2 ? 'active' : 'dashed-line-check'}"></div>
  <div class="progress-line-check step-2 ${currentStepCheck >= 3 ? 'active' : 'dashed-line-check'}"></div>
  <div class="progress-line-check step-3 ${currentStepCheck >= 4 ? 'active' : 'dashed-line-check'}"></div>

  <!-- สเต็ป 1 -->
  <div class="text-center">
      <div class="progress-step-check ${currentStepCheck >= 1 ? 'active' : ''}">1</div>
      <div class="progress-text-check">ผู้รับเหมาส่งมอบงาน</div>
  </div>

  <!-- สเต็ป 2 -->
  <div class="text-center">
      <div class="progress-step-check ${currentStepCheck >= 2 ? 'active' : ''}">2</div>
      <div class="progress-text-check">PM ตรวจสอบ</div>
  </div>

  <!-- สเต็ป 3 -->
  <div class="text-center">
      <div class="progress-step-check ${currentStepCheck >= 3 ? 'active' : ''}">3</div>
      <div class="progress-text-check">แอดมินตรวจสอบ</div>
  </div>

  <!-- สเต็ป 4 -->
  <div class="text-center">
      <div class="progress-step-check ${currentStepCheck >= 4 ? 'active' : ''}">4</div>
      <div class="progress-text-check">เสร็จสมบูรณ์</div>
  </div>
`;

  progressContainerCheck.innerHTML = progress2HTML;
  getCalendar(userData.id);

}
function handleNotificationClick(event, url_path) {
  event.preventDefault(); // ป้องกันการโหลดหน้าใหม่

  $.ajax({
    url: url_path, // ดึงข้อมูลจาก Route
    type: "GET",
    success: function (data) {
      fetchNotifications();


      document.getElementById("exampleModalAutoClick").click();

      userDataFuc(data);



    },
    error: function (xhr, status, error) {
      console.error("Error fetching notifications:", error);
    }
  });



}


function getCalendar(id) {
  $.ajax({
    url: `calendar-user/${id}`, // ดึงข้อมูลจาก Route
    type: "GET",
    success: function (data) {
      /*    let notificationDropdown = $("#notif-center"); */


      let calendarSelect = $("#calendarSelect");
      calendarSelect.empty(); // ล้างรายการเดิม


      if (data.length > 0) {


        // เพิ่ม option แรกเป็น placeholder
        if (window.Laravel && window.Laravel.role === 'admin') {
          calendarSelect.append('<option selected disabled>เลือกผู้จัดการ</option>');
        } else {
          calendarSelect.append('<option selected disabled>เลือกผู้รับเหมา</option>');
        }


        data.forEach(item => {
          let option = `<option value="${item.id}">${item.prefix}  ${item.first_name}   ${item.last_name}</option>`;
          calendarSelect.append(option);
        });
      } else {
        calendarSelect.append('<option value="">ไม่มีข้อมูล</option>');
      }
    },
    error: function (xhr, status, error) {
      console.error("Error fetching notifications:", error);
    }
  });
}



function handleSelectChange() {
  let idUser = $("#calendarSelect").val();

  let projectId = $("#project_id").val();


  if (projectId && idUser) {

    handleEventSaveClick(projectId, idUser)

  } else {
    Swal.fire({
      title: "ผู้จัดการโครงการ:",
      text: `กรุณาเลือกผู้จัดการโครงการ:`,
      icon: "warning",
      showCancelButton: true,
      showConfirmButton: false, // ซ่อนปุ่ม "ตกลง"
      cancelButtonColor: "#3085d6",
      cancelButtonText: "ยกเลิก"
    });

  }


}

async function handleEventSaveClick(projectId, idUser) {
  try {
    /*  console.log(`Event Clicked: Project ID ${idProject}`); */

    // เรียก API ไปที่ `getProject/{idProject}`
    const response = await fetch(`getProject/${projectId}`);
    let date = await response.json();



    if (window.Laravel?.role === 'admin' && date.responsible_pm != null) {
      return Swal.fire({
        title: "โครงการนี้ถูกเพิ่มเเล้ว:",
        text: `กรุณาเลือกผู้จัดการโครงการใหม่:`,
        icon: "warning",
        showCancelButton: true,
        showConfirmButton: false, // ซ่อนปุ่ม "ตกลง"
        cancelButtonColor: "#3085d6",
        cancelButtonText: "ยกเลิก"
      });
    }


    if (window.Laravel?.role === 'pm' && date.responsible_contractor != null) {
      return Swal.fire({
        title: "โครงการนี้ถูกเพิ่มเเล้ว:",
        text: `กรุณาเลือกโครงการใหม่:`,
        icon: "warning",
        showCancelButton: true,
        showConfirmButton: false, // ซ่อนปุ่ม "ตกลง"
        cancelButtonColor: "#3085d6",
        cancelButtonText: "ยกเลิก"
      });
    }

    $.ajax({
      url: `create-calendar/${idUser}/${projectId}`, // แก้ไข URL ให้ถูกต้อง
      type: "GET",
      success: function (data) {
        /*    let notificationDropdown = $("#notif-center"); */

        window.location.href = window.location.href; // โหลดหน้าใหม่ที่ URL เดิม


      },
      error: function (xhr, status, error) {
        console.error("Error fetching notifications:", error);
      }
    });





    document.getElementById("exampleModalAutoClick").click();
    userDataFuc(date);
    // ตรวจสอบว่าการตอบกลับสำเร็จหรือไม่
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

  } catch (error) {
    console.error("Error fetching project data:", error);
  }
}


function userImageFuc(userData) {


  let data = [];
  if (typeof userData.images === "string") {
    data = JSON.parse(userData.images);
  }


  const outputDiv = document.getElementById("output");

  outputDiv.innerHTML = "";
  let basePath = "/storage/uploads/"; // ✅ ตั้งค่าพาธของรูป


  if (data.length > 0) {

    outputDiv.classList.add("container"); // ✅ เพิ่ม class="container" ถ้ามีข้อมูล

    data && data.forEach(item => {
      const div = document.createElement("div");
      div.classList.add("item");

      div.innerHTML = `

  <p><strong>Details:</strong> ${item.details}</p>
  
  <div class="images-work">
      ${item.images.map(img => `<img src="${basePath}${img}" alt="Image">`).join("")}
  </div>

  ${window.Laravel && window.Laravel.role === 'pm' && userData.message_admin ? `<p><strong>Message Admin:</strong> ${userData.message_admin}</p>` : ""}
  ${window.Laravel && window.Laravel.role === 'contractor' && userData.message_pm ? `<p><strong>Message PM:</strong> ${userData.message_pm}</p>` : ""}

  <!-- Form (ซ่อนก่อน) -->
  <form method="POST" action="{{ route('edit-upload-image') }}" enctype="multipart/form-data"
      class="form-group-home-work" id="form-${item.index}">
       @csrf
      <label>รายละเอียด (ลำดับที่ <span class="form-index">${item.index}</span>)</label>
      <input type="hidden" name="id" value="${userData.deliverWorkId || ''}">
      <input type="hidden" name="indexes[]" value="${item.index}">
    <div class="mb-3">
      <textarea class="form-control"  name="details[]"  id="exampleFormControlTextarea1" rows="3"> ${item.details}</textarea>
    </div>
      <label>อัปโหลดรูปภาพ</label>
      <input type="file" name="images[]" class="image-upload form-control" multiple accept=".jpg,.jpeg,.png,.gif,.pdf">
  
      <div class="extra-fields"></div>

      <button type="submit" class="btn btn-primary mt-3 btn-sm">บันทึก</button>
  </form>
      `;


      outputDiv.appendChild(div);
    });
  } else {

    outputDiv.classList.remove("container"); // 🔴 ลบ class ถ้าไม่มีข้อมูล

  }


}




fetchNotifications(); // โหลดข้อมูลครั้งแรกเมื่อเปิดหน้า
