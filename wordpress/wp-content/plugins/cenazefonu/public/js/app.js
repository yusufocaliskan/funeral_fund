(($) => {
  //Get the information from form(s)
  const display_info = document.querySelector(".display-information");
  const registration_form = document.querySelectorAll(
    "#registration_form select, #registration_form input, #registration_form textarea"
  );

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

    //hide family_member_information if there were'nt one
    if (formData["isset_member"] == "no") {
      document.querySelector(".family_member_information").style.display =
        "none";
    } else {
      document.querySelector(".family_member_information").style.display =
        "block";
    }

    //calculates age
    calc_age();

    //make a request to control the form
    await make_request(formData, "form_control_handler")
      .then((res) => {
        return JSON.parse(res);
      })
      .then((res) => {
        if (res.type == "success") {
          //set ages
          document.querySelector(".householder_age").textContent =
            res.ages.householder_age;
          document.querySelector(".member_age").textContent =
            res.ages.member_age;

          set_price_to_form(res.total_price);
          //set genders
          document.querySelector(".householder_age").textContent =
            res.ages.householder_age;
          document.querySelector(".member_age").textContent =
            res.ages.member_age;

          document.querySelector(
            ".information-dispay-template .householder_gender"
          ).textContent = res.lookups.householder_gender;

          document.querySelector(
            ".information-dispay-template .member_gender"
          ).textContent = res.lookups.householder_gender;

          document.querySelector(
            ".information-dispay-template .member_intimacy"
          ).textContent = res.lookups.member_intimacy;

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
    const agreement = document.querySelector('input[name="agreement"]');
    const registration_agreement = document.querySelector(
      'input[name="registration-agreement"]'
    );

    //Registration.
    if (agreement.checked != true || registration_agreement.checked != true) {
      show_message("Sözleşleme koşullarını kabul etmelisiniz.", "bg-warning");
      return;
    }

    await make_request(
      formData,
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
    console.log(this_year - householder_birthyear.value);
    document.querySelector(".householder_age").textContent =
      this_year - householder_birthyear.value;

    const member_birthyear = document.querySelector(
      'select[name="member_birthyear"]'
    );

    document.querySelector(".member_age").textContent =
      this_year - member_birthyear.value;
  }

  //Updates new form price whenever
  //each of year of select box changed.
  const recalculators = document.querySelectorAll(".recalculate-price select");
  recalculators.forEach((rc) => {
    rc.addEventListener("change", async () => {
      await update_total_price(rc);
    });
  });
  async function update_total_price(selectBox) {
    //get housholder age
    const data = {};
    data[`${selectBox.name}`] = selectBox.value;

    //add if one of them all-ready selected
    if (selectBox.name == "householder_birthyear") {
      //look for member_birthyear
      const member_year = document.querySelector(
        'select[name="member_birthyear"]'
      ).value;
      data["member_birthyear"] = member_year;
    }
    if (selectBox.name == "member_birthyear") {
      //look for member_birthyear
      const householder_birthyear = document.querySelector(
        'select[name="householder_birthyear"]'
      ).value;
      data["householder_birthyear"] = householder_birthyear;
    }

    //make request if all them is selected
    const h_day = document.querySelector(
      'select[name="householder_birthday"]'
    ).value;
    const h_month = document.querySelector(
      'select[name="householder_birthmonth"]'
    ).value;

    const isset_member = document.querySelector('input[name="ism"]');

    const m_day = document.querySelector(
      'select[name="member_birthday"]'
    ).value;

    const m_month = document.querySelector(
      'select[name="member_birthmonth"]'
    ).value;

    if (!h_day || !h_month || h_day == 0 || h_month == 0) {
      //do noting
      show_message("Aile reisi için geçerli bir tarih seçin", "bg-warning");
      return;
    }

    if (
      isset_member.value == "yes" &&
      (!m_day || !m_month || m_day == 0 || m_month == 0)
    ) {
      //do noting
      show_message("Aile ferdi için geçerli bir tarih seçin", "bg-warning");
      return;
    }

    await make_request(data, "get_price", "Fiyat güncelleniyor.")
      .then((res) => JSON.parse(res))
      .then((res) => {
        window.scrollTo({ top: 0, behavior: "smooth" });
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

  function show_member_form() {
    const isset_member = document.querySelector(".isset_member");
    const ism = document.querySelector(".ism");
    const family_member_form = document.querySelector(".family_member_form");
    if (!family_member_form) return false;
    if (isset_member?.checked) {
      family_member_form.style.display = "block";
      ism.value = "yes";
    } else {
      family_member_form.style.display = "none";
      ism.value = "no";
    }

    //on clicked
    isset_member.addEventListener("click", () => {
      if (isset_member.checked) {
        family_member_form.style.display = "block";
        ism.value = "yes";
      } else {
        family_member_form.style.display = "none";
        ism.value = "no";
      }
    });
  }

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
          e.target.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
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

  function init() {
    create_tab();
    fill_birthdate_selectbox();
    show_member_form();
  }

  init();
})(jQuery);
