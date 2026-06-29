(() => {
  const calendarRoot = document.querySelector("[data-calendar-root]");
  const eventsPanel = document.querySelector("[data-events-panel]");
  if (!calendarRoot || !eventsPanel) return;

  const panelInner = eventsPanel.querySelector("[data-panel-inner]");
  const monthLabel = calendarRoot.querySelector("[data-calendar-month]");
  const dayGrid = calendarRoot.querySelector("[data-calendar-grid]");
  const prevBtn = calendarRoot.querySelector("[data-calendar-prev]");
  const nextBtn = calendarRoot.querySelector("[data-calendar-next]");

  const eventsByDate = window._calEventsByDate || {};
  const eventDates = new Set(Object.keys(eventsByDate));
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
  const defaultHTML = panelInner?.innerHTML ?? "";
  let selectedIso = null;

  const toIsoDate = (year, month, day) =>
    `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
  const escHtml = (str) => {
    const d = document.createElement("div");
    d.textContent = String(str ?? "");
    return d.innerHTML;
  };

  const buildCardHTML = (
    event,
    size,
  ) => `<article class="cal-event-card ${size}" style="--calendar-event-image: url('${encodeURI(event.image)}');">
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

  const render = () => {
    const year = cursor.getFullYear();
    const monthIndex = cursor.getMonth();
    monthLabel.textContent = monthNames[monthIndex] || "";
    dayGrid.innerHTML = "";

    const firstWeekday = (new Date(year, monthIndex, 1).getDay() + 6) % 7;
    const monthDays = new Date(year, monthIndex + 1, 0).getDate();
    const prevMonthDays = new Date(year, monthIndex, 0).getDate();

    for (let i = firstWeekday; i > 0; i--) {
      const span = document.createElement("span");
      span.className = "cal-day is-outside";
      span.textContent = prevMonthDays - i + 1;
      dayGrid.appendChild(span);
    }

    for (let day = 1; day <= monthDays; day++) {
      const isoDate = toIsoDate(year, monthIndex, day);
      const span = document.createElement("span");
      span.textContent = day;
      span.className = "cal-day";

      if (day === today.getDate() && monthIndex === today.getMonth() && year === today.getFullYear()) {
        span.classList.add("is-today");
      }

      if (eventDates.has(isoDate)) {
        span.classList.add("has-event");
        if (isoDate === selectedIso) span.classList.add("is-selected");
        span.addEventListener("click", () => {
          selectedIso = selectedIso === isoDate ? null : isoDate;
          selectedIso
            ? setPanelContent(
                (eventsByDate[isoDate] || [])
                  .slice(0, 2)
                  .map((ev, i) => buildCardHTML(ev, ["is-large", "is-small"][i]))
                  .join(""),
                (eventsByDate[isoDate] || []).length === 1,
              )
            : setPanelContent(defaultHTML, false);
          render();
        });
      } else {
        span.classList.add("is-no-event");
      }
      dayGrid.appendChild(span);
    }

    const trailing = (7 - (dayGrid.children.length % 7)) % 7;
    for (let day = 1; day <= trailing; day++) {
      const span = document.createElement("span");
      span.className = "cal-day is-outside";
      span.textContent = day;
      dayGrid.appendChild(span);
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
