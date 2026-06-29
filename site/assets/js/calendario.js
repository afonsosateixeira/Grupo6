(() => {
  const calendarRoot = document.querySelector("[data-calendar-root]");
  const eventsPanel = document.querySelector("[data-events-panel]");

  if (!calendarRoot || !eventsPanel) return;

  const panelInner = eventsPanel.querySelector("[data-panel-inner]");

  let eventsByDate = {};
  try {
    eventsByDate = window._calEventsByDate || {};
  } catch (e) {
    eventsByDate = {};
  }

  const eventDateSet = new Set(Object.keys(eventsByDate));

  const monthLabel = calendarRoot.querySelector("[data-calendar-month]");
  const dayGrid = calendarRoot.querySelector("[data-calendar-grid]");
  const prevBtn = calendarRoot.querySelector("[data-calendar-prev]");
  const nextBtn = calendarRoot.querySelector("[data-calendar-next]");

  const monthNames = [
    "Janeiro",
    "Fevereiro",
    "Março",
    "Abril",
    "Maio",
    "Junho",
    "Julho",
    "Agosto",
    "Setembro",
    "Outubro",
    "Novembro",
    "Dezembro",
  ];

  const today = new Date();
  const cursor = new Date(today.getFullYear(), today.getMonth(), 1);
  const defaultHTML = panelInner ? panelInner.innerHTML : "";
  let selectedIso = null;

  const toIsoDate = (year, monthIndex, day) => {
    const safeMonth = String(monthIndex + 1).padStart(2, "0");
    const safeDay = String(day).padStart(2, "0");
    return `${year}-${safeMonth}-${safeDay}`;
  };

  const escHtml = (str) => {
    const d = document.createElement("div");
    d.textContent = String(str ?? "");
    return d.innerHTML;
  };

  const buildCardHTML = (event, sizeClass) =>
    `<article class="cal-event-card ${sizeClass}" style="--calendar-event-image: url('${encodeURI(event.image)}');">
      <div class="cal-event-card__overlay"></div>
      <div class="cal-event-card__content">
        <h2>${escHtml(event.name)}</h2>
        <div class="cal-event-card__meta">
          <span><i class="fa-regular fa-clock"></i>${escHtml(event.date_label)}</span>
          <span><i class="fa-solid fa-location-dot"></i>${escHtml(event.location)}</span>
        </div>
      </div>
    </article>`;

  const setPanelContent = (html, single) => {
    if (!panelInner) return;
    panelInner.classList.add("is-updating");
    setTimeout(() => {
      panelInner.innerHTML = html;
      panelInner.classList.toggle("is-single", !!single);
      panelInner.classList.remove("is-updating");
    }, 150);
  };

  const showDayEvents = (isoDate) => {
    const events = (eventsByDate[isoDate] || []).slice(0, 2);
    const sizes = ["is-large", "is-small"];
    const html = events.map((ev, i) => buildCardHTML(ev, sizes[i] || "is-large")).join("");
    setPanelContent(html, events.length === 1);
  };

  const restoreDefault = () => {
    setPanelContent(defaultHTML, false);
  };

  const render = () => {
    const year = cursor.getFullYear();
    const monthIndex = cursor.getMonth();

    monthLabel.textContent = monthNames[monthIndex] || "";
    dayGrid.innerHTML = "";

    const firstWeekday = (new Date(year, monthIndex, 1).getDay() + 6) % 7;
    const monthDays = new Date(year, monthIndex + 1, 0).getDate();
    const previousMonthDays = new Date(year, monthIndex, 0).getDate();

    for (let i = firstWeekday; i > 0; i -= 1) {
      const day = previousMonthDays - i + 1;
      const dateCell = document.createElement("span");
      dateCell.className = "cal-day is-outside";
      dateCell.textContent = String(day);
      dayGrid.appendChild(dateCell);
    }

    for (let day = 1; day <= monthDays; day += 1) {
      const isoDate = toIsoDate(year, monthIndex, day);
      const dateCell = document.createElement("span");
      dateCell.textContent = String(day);

      const classes = ["cal-day"];

      if (day === today.getDate() && monthIndex === today.getMonth() && year === today.getFullYear()) {
        classes.push("is-today");
      }

      if (eventDateSet.has(isoDate)) {
        classes.push("has-event");
        if (isoDate === selectedIso) classes.push("is-selected");

        dateCell.addEventListener("click", () => {
          if (selectedIso === isoDate) {
            selectedIso = null;
            restoreDefault();
          } else {
            selectedIso = isoDate;
            showDayEvents(isoDate);
          }
          render();
        });
      } else {
        classes.push("is-no-event");
      }

      dateCell.className = classes.join(" ");
      dayGrid.appendChild(dateCell);
    }

    const cellsAfterCurrentMonth = dayGrid.children.length;
    const trailingCells = (7 - (cellsAfterCurrentMonth % 7)) % 7;

    for (let day = 1; day <= trailingCells; day += 1) {
      const dateCell = document.createElement("span");
      dateCell.className = "cal-day is-outside";
      dateCell.textContent = String(day);
      dayGrid.appendChild(dateCell);
    }
  };

  prevBtn.addEventListener("click", () => {
    cursor.setMonth(cursor.getMonth() - 1);
    render();
  });

  nextBtn.addEventListener("click", () => {
    cursor.setMonth(cursor.getMonth() + 1);
    render();
  });

  render();
})();
