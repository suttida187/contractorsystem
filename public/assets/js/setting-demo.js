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
                      <a href="#" onclick="handleNotificationClick(event, '${notification.url}')">
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
    document.getElementById("stepStatusNull").style.display = "block";
    document.getElementById("stepStatus").style.display = "none";
  } else {
    document.getElementById("stepStatusNull").style.display = "none";
    document.getElementById("stepStatus").style.display = "block";
  }
  // ใส่ข้อมูลลงใน Modal

  // เติมค่าลงใน Modal
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

  let adminName = [userData.admin_prefix, userData.admin_first_name, userData
    .admin_last_name
  ]
    .filter(Boolean) // ลบค่าที่เป็น null หรือ undefined
    .join(" "); // รวมเป็น string

  document.getElementById("caretaker_admin").value = adminName || "";
  document.getElementById("caretaker_admin_phone").value = userData.admin_phone ||
    "";

  // ✅ เช็คค่า PM
  let pmName = [userData.pm_prefix, userData.pm_first_name, userData.pm_last_name]
    .filter(Boolean)
    .join(" ");

  document.getElementById("caretaker_pm").value = pmName || "";
  document.getElementById("caretaker_pm_phone").value = userData.pm_phone || "";

  // ✅ เช็คค่า Contractor
  let contractorName = [userData.contractor_prefix, userData
    .contractor_first_name, userData.contractor_last_name
  ]
    .filter(Boolean)
    .join(" ");

  document.getElementById("caretaker_contractor").value = contractorName || "";
  document.getElementById("caretaker_contractor_phone").value = userData
    .contractor_phone || "";
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


fetchNotifications(); // โหลดข้อมูลครั้งแรกเมื่อเปิดหน้า
