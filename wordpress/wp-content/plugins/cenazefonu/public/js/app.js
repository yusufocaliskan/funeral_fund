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

      //display tab content
      activeTabContent = document.querySelector(
        `.tab-content[data-tab="${tabId}"]`
      );
      activeTabContent.style.display = "block";
    });
  });
}

function init() {
  //Run
  create_tab();
}
init();
