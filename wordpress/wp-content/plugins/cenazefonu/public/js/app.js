(($) => {
  //Get the information from form(s)

  const display_info = document.querySelector(".display-information");
  const registration_form = document.querySelectorAll(
    "#registration_form select, #registration_form input, #registration_form textarea"
  );
  const intimacy_lookup = { esi: "Eşi", cocugu: "Çocuğu" };
  const gender_lookup = { woman: "Kadın", man: "Erkek" };

  //show information to user
  const formData = {};

  display_info?.addEventListener("click", display_information);
  async function display_information(e) {
    window.scrollTo({ top: 0, behavior: "smooth" });

    registration_form.forEach((formElement) => {
      formData[formElement.name] = formElement.value;

      //Set isset member
      if (formElement.name == "isset_member") {
        formData[formElement.name] = formElement.checked ? "yes" : "no";
      }

      //set all information the placeholder
      const el = document.querySelector(
        `.information-dispay-template .${formElement.name}`
      );

      if (el) {
        el.textContent = formElement.value;
      }
    });

    const member_info = JSON.parse(localStorage.getItem("member_info"));

    //hide family_member_information if there were'nt one
    if (member_info && member_info.length <= 0) {
      document.querySelector(".family_member_information").style.display =
        "none";
    } else {
      document.querySelector(".family_member_information").style.display =
        "block";
    }

    //calculates age
    calc_age();
    const memberData = JSON.parse(localStorage.getItem("member_info"));
    const data = { formData: formData, memberData: memberData };
    //make a request to control the form
    await make_request(data, "form_control_handler")
      .then((res) => {
        return JSON.parse(res);
      })
      .then((res) => {
        console.log(res);
        if (res.type == "success") {
          //set ages
          document.querySelector(".householder_age").textContent =
            res.ages.householder_age;

          set_price_to_form(res.total_price);
          //set genders
          document.querySelector(".householder_age").textContent =
            res.ages.householder_age;

          document.querySelector(
            ".information-dispay-template .householder_gender"
          ).textContent = res.lookups.householder_gender;

          //form status
          document.querySelector('input[name="fs"]').value = "y";
          console.log(res.type);
          show_message(res.message, "bg-success");

          //save the that
          //we will use it later
          localStorage.setItem("formData", JSON.stringify(formData));

          go_confirmation_tab();
        } else {
          //form status
          document.querySelector('input[name="fs"]').value = "n";
          show_message(res.message, "bg-danger");
        }
      });

    e.preventDefault();
  }

  //Listen if the form submitted.
  const reg_form = document.querySelector("#registration_form");
  reg_form?.addEventListener("submit", async (e) => {
    await saveIt(e);
  });

  //Save the form!
  async function saveIt(e) {
    e.preventDefault();

    //get the form data from storage
    const formData = JSON.parse(localStorage.getItem("formData"));
    const memberData = JSON.parse(localStorage.getItem("member_info"));
    const agreement = document.querySelector('input[name="agreement"]');
    const registration_agreement = document.querySelector(
      'input[name="registration-agreement"]'
    );

    //Registration.
    if (agreement.checked != true || registration_agreement.checked != true) {
      show_message("Sözleşleme koşullarını kabul etmelisiniz.", "bg-warning");
      return;
    }
    const data = { formData: formData, memberData: memberData };

    await make_request(
      data,
      "add_new_registration",
      "Form kaydediliyor,bir saniye..."
    )
      .then((res) => JSON.parse(res))
      .then((res) => {
        if (res.type != "success") {
          show_message(res.message, "bg-danger");
        }

        //if it is success.
        //show message an clear the form!
        if (res.type == "success") {
          show_message(res.message, "bg-success");
        }

        localStorage.removeItem("formData");
        localStorage.removeItem("member_info");

        //Clear all form element.
        setTimeout(() => {
          location.reload();
        }, 3000);
        go_info_tab();
      });
  }

  /**
   * embeding price to the form
   * @param {*} price
   */
  function set_price_to_form(price) {
    //set the price
    const form_price = document.querySelectorAll(".form_price");
    form_price.forEach((fp) => {
      fp.textContent = price;
    });
    document.querySelector('input[name="form_price"]').value = price;
  }
  /**
   * calculates age
   * @param {integer} year
   */
  function calc_age(year) {
    const current_year = new Date();
    const this_year = current_year.getFullYear();

    //house holder
    const householder_birthyear = document.querySelector(
      'select[name="householder_birthyear"]'
    );

    document.querySelector(".householder_age").textContent =
      this_year - householder_birthyear.value;

    // const member_birthyear = document.querySelector(
    //   'select[name="member_birthyear"]'
    // );

    // document.querySelector(".member_age").textContent =
    //   this_year - member_birthyear.value;
  }

  //Updates new form price whenever
  //each of year of select box changed.
  const recalculators = document.querySelectorAll(".recalculate-price select");
  recalculators.forEach((rc) => {
    rc.addEventListener("change", async () => {
      await update_total_price();
    });
  });

  async function update_total_price() {
    //get housholder age
    const data = {};
    data["householder_birthyear"] = document.querySelector(
      'select[name="householder_birthyear"]'
    ).value;

    //Memebers
    const members = JSON.parse(localStorage.getItem("member_info"));
    if (members && members.length > 0) {
      data["members"] = members;
    }

    await make_request(data, "get_price", "Fiyat güncelleniyor.")
      .then((res) => JSON.parse(res))
      .then((res) => {
        if (res.type != "success") {
          show_message(res.message, "bg-danger");
          return;
        }
        //window.scrollTo({ top: 0, behavior: "smooth" });
        set_price_to_form(res.new_price);
      });
  }

  /**
   * show a toast message
   */
  function show_message(message, type = "bg-primary") {
    const liveToast = document.getElementById("liveToast");
    document.querySelector(".toast-container").style.display = "block";
    liveToast.querySelector(".toast-body").textContent = message;
    liveToast.classList.remove("bg-danger");
    liveToast.classList.remove("bg-primary");
    liveToast.classList.remove("bg-warning");
    liveToast.classList.add(type);
    const toast = new bootstrap.Toast(liveToast);
    toast.show();
  }

  function show_loading(message = "Bir saniye...") {
    document.querySelector(".loading-body span").textContent = message;
    document.querySelector(".loading").style.display = "flex";
  }

  function hide_loading() {
    document.querySelector(".loading").style.display = "none";
  }

  /**
   * makes some ajax requeest
   * @param {object} data the data that would send
   * @param {string} action name of action of worpdrss
   * @returns
   */
  async function make_request(data, action, loading_message) {
    show_loading(loading_message);
    const response = await $.ajax({
      url: "/wp-admin/admin-ajax.php",
      type: "post",
      data: {
        action: action,
        data: data,
      },
      success: () => {
        hide_loading();
      },
      error: () => {
        hide_loading();
      },
    });

    return response;
  }

  document.querySelectorAll(".go-to-form").forEach((go) => {
    go.addEventListener("click", function () {
      window.scrollTo({ top: 0, behavior: "smooth" });
      go_form_tab();
    });
  });

  /**
   * triggers click event. to go to tab-0
   */
  function go_info_tab() {
    _trigger('.tab[data-tab="0"]');
  }

  /**
   * triggers click event. to go to tab-1
   */
  function go_form_tab() {
    _trigger('.tab[data-tab="1"]');
  }

  /**
   * triggers click event. to go to tab-2
   */
  function go_confirmation_tab() {
    _trigger('.tab[data-tab="2"]');
  }

  //Utils
  const tabs = document.querySelectorAll(".tab");
  const tab_contents = document.querySelectorAll(".tab-content");
  let activeTabContent;
  let activeTab;
  function create_tab() {
    tabs.forEach((tab) => {
      //listen click event
      tab.addEventListener("click", () => {
        const tabId = tab.getAttribute("data-tab");

        //Clear all active class
        tabs.forEach((t) => {
          t.classList.remove("active");
        });

        //add active class this to this
        activeTab = document.querySelector(`.tab[data-tab="${tabId}"]`);
        activeTab.classList.add("active");

        //hide all other tab-content
        tab_contents.forEach((tabContent) => {
          tabContent.style.display = "none";
        });

        //throwAnEvent
        const throwAnEvent = new CustomEvent("TabClicked", {
          detail: { clicked_tab: tabId },
        });
        document.dispatchEvent(throwAnEvent);

        //display tab content
        activeTabContent = document.querySelector(
          `.tab-content[data-tab="${tabId}"]`
        );

        //before display the last tab make sure the form is fiiled.
        const form_status = document.querySelector('input[name="fs"]').value;
        if (form_status == "n" && tabId == 2) {
          show_message("Formu doldurun", "bg-danger");
          go_form_tab();
        } else {
          activeTabContent.style.display = "block";
        }
      });
    });
  }

  /**
   * Create birth day selections
   */
  function fill_birthdate_selectbox() {
    //day
    const day_selects = document.querySelectorAll(".birthday-select");
    const month_selects = document.querySelectorAll(".month-select");
    const year_selects = document.querySelectorAll(".year-select");

    day_selects.forEach((day_select) => {
      for (let i = 1; i < 32; i++) {
        let option = document.createElement("option");
        option.value = i;
        option.textContent = i;
        day_select.appendChild(option);
      }
    });

    const month_names = [
      "Ocak",
      "Şubat",
      "Mart",
      "Nisan",
      "Mayıs",
      "Haziran",
      "Temmuz",
      "Ağustos",
      "Eylül",
      "Ekim",
      "Kasım",
      "Aralık",
    ];
    month_selects.forEach((month_select) => {
      for (let i = 1; i < 13; i++) {
        let option = document.createElement("option");
        option.value = i;
        option.textContent = `${i} - ${month_names[i - 1]}`;
        month_select.appendChild(option);
      }
    });

    const date = new Date();
    const currentYear = date.getFullYear();
    year_selects.forEach((year_select) => {
      for (let i = currentYear; i > 1922; i--) {
        let option = document.createElement("option");
        option.value = i;
        option.textContent = i;
        year_select.appendChild(option);
      }
    });
  }

  // function show_member_form() {
  //   const isset_member = document.querySelector(".isset_member");
  //   const ism = document.querySelector(".ism");
  //   const family_member_form = document.querySelector(".family_member_form");
  //   if (!family_member_form) return false;
  //   if (isset_member?.checked) {
  //     family_member_form.style.display = "block";
  //     ism.value = "yes";
  //   } else {
  //     family_member_form.style.display = "none";
  //     ism.value = "no";
  //   }

  //   //on clicked
  //   isset_member.addEventListener("click", () => {
  //     if (isset_member.checked) {
  //       family_member_form.style.display = "block";
  //       ism.value = "yes";
  //     } else {
  //       family_member_form.style.display = "none";
  //       ism.value = "no";
  //     }
  //   });
  // }

  //Trigger!
  function _trigger(el) {
    var element = document.querySelector(el);
    var event = new Event("click");
    element.dispatchEvent(event);
  }
  function set_as_done(tabId) {
    document.querySelector(`.tab[data-tab="${tabId}"]`).classList.add("done");
  }
  function remove_done(tabId) {
    document
      .querySelector(`.tab[data-tab="${tabId}"]`)
      .classList.remove("done");
  }

  //display information
  //EVENT LISTENER
  document.addEventListener("click", (e) => {
    //open member info
    const element_class = e.target.classList[0];
    if (element_class == "member-td") {
      display_member_info(e);
      return;
    }
    if (element_class == "approve-registration") {
      approve_registration(e);
      return;
    }
    if (element_class == "reject-registration") {
      reject_registration(e);
      return;
    }
    if (element_class == "delete-registration") {
      delete_registration(e);
      return;
    }
    if (element_class == "close-member-info-popup") {
      close_member_info(e);
      return;
    }
  });

  function close_member_info(e) {
    console.log(e.target.parentNode.parentNode);
    e.target.parentNode.parentNode.style.display = "none";
  }

  function display_member_info(e) {
    const row = e.target.parentNode;
    const memberId = row.getAttribute("data-member-id");
    const memberInfoRow = document.querySelector(
      `.member-list-table tr[data-member-info-id="${memberId}"]`
    );

    const allInfoTRs = document.querySelectorAll(
      `.member-list-table tr[class="member-info-tr"]`
    );

    //hide all others
    allInfoTRs.forEach((tr) => {
      tr.style.display = "none";
    });

    //Display the clicked one.
    if (!memberInfoRow) return false;

    memberInfoRow.style.display = "table-row";
  }

  //approvement
  async function approve_registration(e) {
    const button = e.target;
    const memberId = button.getAttribute("data-member-id");
    const data = { memberId: memberId };

    await make_request(data, "approve_member_registration", "", false)
      .then((res) => JSON.parse(res))
      .then((res) => {
        if (res.type == "success") {
          show_message(res.message, "bg-success");
          const currentTr = document.querySelector(
            `tr[data-member-id="${memberId}"]`
          );

          const label = currentTr.querySelector("td span");
          console.log(label);
          label.textContent = "Onaylı";
          label.classList.remove("bg-warning");
          label.classList.remove("bg-danger");
          label.classList.add("bg-success");
          return;
        }

        show_message(res.message, "bg-danger");
      });
    e.preventDefault();
  }
  async function delete_registration(e) {
    const button = e.target;
    const memberId = button.getAttribute("data-member-id");
    const data = { memberId: memberId };
    if (!confirm("Emin misin?")) {
      return false;
    }
    await make_request(data, "delete_member_registration", "", false)
      .then((res) => JSON.parse(res))
      .then((res) => {
        if (res.type == "success") {
          //show_message(res.message, "bg-success");
          // const currentTr = document.querySelector(
          //   `tr[data-member-info-id="${memberId}"]`
          // );

          const currentInfoTr = document.querySelector(
            `tr[data-member-info-tr="${memberId}"]`
          );
          //Remove TR
          const tr =
            e.target.parentNode.parentNode.parentNode.parentNode.parentNode;
          tr.remove();
          return;
        }

        show_message(res.message, "bg-danger");
      });
    e.preventDefault();
  }
  async function reject_registration(e) {
    const button = e.target;
    const memberId = button.getAttribute("data-member-id");
    const data = { memberId: memberId };

    await make_request(data, "reject_member_registration", "", false)
      .then((res) => JSON.parse(res))
      .then((res) => {
        if (res.type == "success") {
          show_message(res.message, "bg-success");
          const currentTr = document.querySelector(
            `tr[data-member-id="${memberId}"]`
          );

          const label = currentTr.querySelector("td span");
          label.textContent = "Reddedildi";
          label.classList.remove("bg-success");
          label.classList.remove("bg-warning");
          label.classList.add("bg-danger");
          return;
        }

        show_message(res.message, "bg-danger");
      });
    e.preventDefault();
  }

  //looad more
  const load_more_button = document.querySelector(".load-more");
  if (load_more_button) {
    load_more_button.addEventListener("click", async (e) => {
      const member_list_table = document.querySelector("table");
      const limit = parseInt(
        document.querySelector('input[name="limit"]').value
      );

      const data = { load_more: true, limit: limit + 10 };
      await make_request(data, "main_template_load_more").then((res) => {
        const last_row =
          member_list_table.rows[member_list_table.rows.length - 2];
        last_row.insertAdjacentHTML("afterend", res);
        document.querySelector('input[name="limit"]').value = limit + 10;
      });

      e.preventDefault();
    });
  }

  //Add new memeber to the form
  const btn_add_new_member = document.querySelector(".add-member");
  btn_add_new_member.addEventListener("click", function (e) {
    const getMemberInfo = localStorage.getItem("member_info");
    let member_info = getMemberInfo ? JSON.parse(getMemberInfo) : [];
    const member_name = document.querySelector('input[name="member_name"]');
    const member_lastname = document.querySelector(
      'input[name="member_lastname"]'
    );
    const member_birthday = document.querySelector(
      'select[name="member_birthday"]'
    );
    const member_birthmonth = document.querySelector(
      'select[name="member_birthmonth"]'
    );
    const member_birthyear = document.querySelector(
      'select[name="member_birthyear"]'
    );
    const member_gender = document.querySelector(
      'select[name="member_gender"]'
    );
    const member_intimacy = document.querySelector(
      'select[name="member_intimacy"]'
    );

    if (!member_name.value || !member_lastname.value) {
      show_message("Adı ve soyadı alanları doldurun", "bg-danger");
      return;
    }
    if (
      !member_birthday.value ||
      !member_birthmonth.value ||
      !member_birthyear.value ||
      member_birthday.value == 0 ||
      member_birthmonth.value == 0 ||
      member_birthyear.value == 0
    ) {
      show_message("Aile ferdi için doğum tarihi girin", "bg-danger");
      return;
    }
    //is it his/her child up to 25 years, don't added
    if (
      member_intimacy.value == "cocugu" &&
      new Date().getFullYear() - member_birthyear.value > 25
    ) {
      show_message("En büyük 25 yaşında olan aile ferdi eklenebilir.");
      return;
    }

    if (!member_gender.value || member_gender.value == 0) {
      show_message("Geçerli bir cinsiyet seçin", "bg-danger");
      return;
    }
    if (!member_intimacy.value || member_intimacy.value == 0) {
      show_message("Yakınlık derecesini seçmediniz", "bg-danger");
      return;
    }

    member_info.push({
      member_name: member_name.value,
      member_lastname: member_lastname.value,
      member_birthday: member_birthday.value,
      member_birthmonth: member_birthmonth.value,
      member_birthyear: member_birthyear.value,
      member_gender: member_gender.value,
      member_intimacy: member_intimacy.value,
    });

    member_name.value = "";
    member_lastname.value = "";
    member_birthday.value = 0;
    member_birthmonth.value = 0;
    member_birthyear.value = 0;
    member_gender.value = 0;
    member_intimacy.value = 0;
    _trigger(".close-modal");
    //Save on local storage
    localStorage.setItem("member_info", JSON.stringify(member_info));
    update_total_price();
    display_members();
    document.querySelector('input[name="isset_member"]').value = "yes";
  });

  function display_members() {
    const members = JSON.parse(localStorage.getItem("member_info"));
    const memberListDiv = document.querySelectorAll(".member-list");
    memberListDiv.forEach((memDiv) => {
      const noDelete = memDiv.getAttribute("data-no-delete");

      let member_output = "";
      if (!members || members.length <= 0) {
        memDiv.innerHTML = `<span style="
      text-align: center;
      padding: 10px;
      color: #888;">Ekli aile ferdi yok.</span> `;
        return;
      }
      document.querySelector('input[name="isset_member"]').value = "yes";
      members?.forEach((member, index) => {
        if (noDelete != "yes") {
          member_output += `<div  class="list-group-item list-group-item-action " aria-current="true">
        <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">${index + 1}. ${member.member_name}</h5>
        <small style="cursor:pointer;" class="btn btn-danger remove-member" data-index="${index}">
          Sil
        </small>
        </div>
        <p class="mb-1">${member.member_birthday}/${member.member_birthmonth}/${
            member.member_birthyear
          }</p>
        <div>
            <small class="member_intimacy">${
              intimacy_lookup[member.member_intimacy]
            }</small> - 
            <small class="member_gender">${
              gender_lookup[member.member_gender]
            }</small>
        </div>
      </div>`;
        } else {
          member_output += `<div  class="list-group-item list-group-item-action " aria-current="true">
          <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1">${index + 1}. ${member.member_name}</h5>
          
          </div>
          <p class="mb-1">${member.member_birthday}/${
            member.member_birthmonth
          }/${member.member_birthyear}</p>
          <div>
              <small class="member_intimacy2">${
                intimacy_lookup[member.member_intimacy]
              }</small> - 
              <small class="member_gender2">${
                gender_lookup[member.member_gender]
              }</small>
          </div>
        </div>`;
        }
      });

      memDiv.innerHTML = member_output;
    });
  }

  //remove member
  document.addEventListener("click", function (e) {
    const member_list = JSON.parse(localStorage.getItem("member_info"));
    if (e.target.classList.contains("remove-member")) {
      const member_index = e.target.getAttribute("data-index");
      const new_member_list = member_list.filter((item, index) => {
        if (index != member_index) {
          return item;
        }
      });
      localStorage.setItem("member_info", JSON.stringify(new_member_list));
      display_members();
      update_total_price();
    }
  });

  function init() {
    create_tab();
    fill_birthdate_selectbox();
    //show_member_form();
    display_members();
  }

  init();
})(jQuery);
