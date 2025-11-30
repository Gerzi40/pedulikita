// ============================================================================
// FORM HANDLER - Remove empty inputs before submit
// ============================================================================
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('filterForm');
    if (!form) return;

    form.addEventListener('submit', function () {
        form.querySelectorAll('input[name], select[name]').forEach(el => {
            if (!el.value || el.value.trim() === '') {
                el.removeAttribute('name');
            }
        });
    });
});

// ============================================================================
// DATEPICKER COMPONENT
// ============================================================================

// DOM Elements
const datepicker = document.querySelector(".datepicker");
const dateInput = document.querySelector(".date-input");
const yearInput = datepicker.querySelector(".year-input");
const monthInput = datepicker.querySelector(".month-input");
const cancelBtn = datepicker.querySelector(".cancel");
const applyBtn = datepicker.querySelector(".apply");
const nextBtn = datepicker.querySelector(".next");
const prevBtn = datepicker.querySelector(".prev");
const dates = datepicker.querySelector(".dates");

// State
let selectedDate = new Date();
let year = selectedDate.getFullYear();
let month = selectedDate.getMonth();

// --- Event Listeners ---

// Show datepicker
dateInput.addEventListener("click", (e) => {
    e.stopPropagation();
    closeAllDropdowns();
    datepicker.hidden = false;
});

// Hide datepicker
cancelBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    datepicker.hidden = true;
});

// Close datepicker on outside click
document.addEventListener("click", (e) => {
    const datepickerContainer = datepicker.parentNode;
    if (!datepickerContainer.contains(e.target)) {
        datepicker.hidden = true;
    }
});

// Apply selected date
applyBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    console.log(selectedDate);
    dateInput.value = formatDate(selectedDate);
    datepicker.hidden = true;
});

// Navigation - Next month
nextBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    if (month === 11) year++;
    month = (month + 1) % 12;
    displayDates();
});

// Navigation - Previous month
prevBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    if (month === 0) year--;
    month = (month - 1 + 12) % 12;
    displayDates();
});

// Month input change
monthInput.addEventListener("change", (e) => {
    e.stopPropagation();
    month = monthInput.selectedIndex;
    displayDates();
});

// Year input change
yearInput.addEventListener("change", (e) => {
    e.stopPropagation();
    const newYear = parseInt(yearInput.value, 10) || new Date().getFullYear();
    year = Math.min(2100, Math.max(1900, newYear));
    yearInput.value = year;
    displayDates();
});

// --- Helper Functions ---

const formatDate = (date) => {
    const y = date.getFullYear();
    const m = String(date.getMonth() + 1).padStart(2, "0");
    const d = String(date.getDate()).padStart(2, "0");
    return `${y}-${m}-${d}`;
};

const updateYearMonth = () => {
    monthInput.selectedIndex = month;
    yearInput.value = year;
};

const handleDateClick = (e) => {
    e.stopPropagation();
    const button = e.target;

    // Remove 'selected' class from other buttons
    const selected = dates.querySelector(".selected");
    selected && selected.classList.remove("selected");

    // Add 'selected' class to current button
    button.classList.add("selected");

    // Set the selected date
    selectedDate = new Date(year, month, parseInt(button.textContent));
};

const createButton = (text, isDisabled = false) => {
    const button = document.createElement("button");
    button.type = "button";
    button.textContent = text;
    button.disabled = isDisabled;
    
    if (!isDisabled) {
        const buttonDate = new Date(year, month, text).toDateString();
        const today = buttonDate === new Date().toDateString();
        const selected = buttonDate === selectedDate.toDateString();

        button.classList.toggle("today", today);
        button.classList.toggle("selected", selected);
    }
    
    return button;
};

// Render dates in calendar
const displayDates = () => {
    // Update year & month
    updateYearMonth();

    // Clear existing dates
    dates.innerHTML = "";

    // Display last week of previous month
    const lastOfPrevMonth = new Date(year, month, 0);

    for (let i = 0; i <= lastOfPrevMonth.getDay(); i++) {
        // If last day is Saturday, don't show leading dates
        if (lastOfPrevMonth.getDay() === 6) break;

        const text = lastOfPrevMonth.getDate() - lastOfPrevMonth.getDay() + i;
        const button = createButton(text, true);
        dates.appendChild(button);
    }

    // Display current month
    const lastOfMonth = new Date(year, month + 1, 0);

    for (let i = 1; i <= lastOfMonth.getDate(); i++) {
        const button = createButton(i, false);
        button.addEventListener("click", handleDateClick);
        dates.appendChild(button);
    }

    // Display first week of next month
    const firstOfNextMonth = new Date(year, month + 1, 1);

    for (let i = firstOfNextMonth.getDay(); i < 7; i++) {
        // If first day is Sunday, don't show trailing dates
        if (firstOfNextMonth.getDay() === 0) break;

        const text = firstOfNextMonth.getDate() - firstOfNextMonth.getDay() + i;
        const button = createButton(text, true);
        dates.appendChild(button);
    }
};

// Initialize datepicker
displayDates();

// ============================================================================
// CATEGORY DROPDOWN
// ============================================================================

const categoryDropdown = document.querySelector(".category-dropdown");
const categoryTrigger = categoryDropdown.querySelector(".dropdown-trigger");
const categoryPanel = categoryDropdown.querySelector(".dropdown-panel");
const categoryInput = document.getElementById("categoryInput");
const categoryLabel = categoryDropdown.querySelector(".dropdown-label");

// Toggle category dropdown
categoryTrigger.addEventListener("click", (e) => {
    e.stopPropagation();
    const isOpen = categoryDropdown.classList.contains("open");
    closeAllDropdowns();
    datepicker.hidden = true;
    if (!isOpen) {
        categoryPanel.classList.remove("hidden");
        categoryDropdown.classList.add("open");
    }
});

// Select category option
categoryPanel.querySelectorAll("button").forEach(btn => {
    btn.addEventListener("click", () => {
        const value = btn.dataset.value;
        const text = btn.textContent.trim();

        categoryInput.value = value;
        categoryLabel.innerText = text;

        categoryPanel.classList.add("hidden");
        categoryDropdown.classList.remove("open");
    });
});

// ============================================================================
// PROVINCE DROPDOWN
// ============================================================================

const provinceDropdown = document.querySelector(".province-dropdown");
const provinceTrigger = provinceDropdown.querySelector(".dropdown-trigger");
const provincePanel = provinceDropdown.querySelector(".dropdown-panel");
const provinceInput = document.getElementById("provinceInput");
const provinceLabel = provinceDropdown.querySelector(".dropdown-label");

// Toggle province dropdownD
provinceTrigger.addEventListener("click", (e) => {
    e.stopPropagation();
    const isOpen = provinceDropdown.classList.contains("open");
    closeAllDropdowns();
    datepicker.hidden = true;
    provincePanel.classList.toggle("hidden");
    provinceDropdown.classList.toggle("open");
});

// Select province option
provincePanel.querySelectorAll("button").forEach(btn => {
    btn.addEventListener("click", () => {
        const value = btn.dataset.value;
        const text = btn.textContent.trim();

        provinceInput.value = value;
        provinceLabel.innerText = text;

        provincePanel.classList.add("hidden");
        provinceDropdown.classList.remove("open");

        // Auto-load cities for selected province
        loadCities(value);
    });
});

// ============================================================================
// CITY DROPDOWN
// ============================================================================

const cityDropdown = document.querySelector(".city-dropdown");
const cityTrigger = cityDropdown.querySelector(".dropdown-trigger");
const cityPanel = document.getElementById("cityDropdownPanel");
const cityInput = document.getElementById("cityInput");
const cityLabel = cityDropdown.querySelector(".dropdown-label");

// Get selected values from hidden inputs (not template syntax)
const getSelectedCity = () => cityInput.value;
const getSelectedProvince = () => provinceInput.value;

// Toggle city dropdown
cityTrigger.addEventListener("click", (e) => {
    e.stopPropagation();
    closeAllDropdowns();
    datepicker.hidden = true;
    cityDropdown.classList.toggle("open");
    cityPanel.classList.toggle("hidden");
});

// Bind click events to city buttons
function bindCityClick() {
    cityPanel.querySelectorAll("button").forEach(btn => {
        btn.addEventListener("click", () => {
            const value = btn.dataset.value;
            const text = btn.textContent.trim();

            cityInput.value = value;
            cityLabel.innerText = text;

            cityPanel.classList.add("hidden");
            cityDropdown.classList.remove("open");
        });
    });
}

// Load city list based on province
function loadCities(provinceId) {
    cityPanel.innerHTML = `<button type="button">Loading...</button>`;

    if (!provinceId) {
        cityPanel.innerHTML = `<button type="button" data-value="">Semua Kota</button>`;
        bindCityClick();

        // Only reset if no city is selected
        if (!getSelectedCity()) {
            cityInput.value = "";
            cityLabel.innerText = "Semua Kota";
        }
        return;
    }

    fetch(`/provinces/${provinceId}/cities`)
        .then(res => res.json())
        .then(data => {
            const currentSelectedCity = getSelectedCity();
            let html = `<button type="button" data-value="">Semua Kota</button>`;

            data.forEach(city => {
                html += `
                    <button type="button"
                            data-value="${city.id}"
                            class="${currentSelectedCity == city.id ? 'active' : ''}">
                        ${city.name}
                    </button>
                `;
            });

            cityPanel.innerHTML = html;

            // Re-bind click events
            bindCityClick();

            // Sync selected city label
            if (currentSelectedCity) {
                const activeBtn = cityPanel.querySelector(`button[data-value="${currentSelectedCity}"]`);
                if (activeBtn) {
                    cityLabel.innerText = activeBtn.textContent.trim();
                }
            }
        })
        .catch(error => {
            console.error('Error loading cities:', error);
            cityPanel.innerHTML = `<button type="button" data-value="">Error loading cities</button>`;
            bindCityClick();
        });
}

// Initialize city dropdown on page load if province is selected
const initialProvince = getSelectedProvince();
if (initialProvince) {
    loadCities(initialProvince);
}

// ============================================================================
// GLOBAL DROPDOWN HANDLER
// ============================================================================

// Close all dropdowns on outside click
document.addEventListener("click", () => {
    closeAllDropdowns();
    datepicker.hidden = true;
});

// Helper function to close all dropdowns
function closeAllDropdowns() {
    document.querySelectorAll(".custom-dropdown").forEach(dd => {
        dd.classList.remove("open");
        dd.querySelector(".dropdown-panel")?.classList.add("hidden");
    });
}