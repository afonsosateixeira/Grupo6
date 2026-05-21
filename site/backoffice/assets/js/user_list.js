let table = new DataTable("#userList", {
  language: {
    url: "assets/js/pt_PT.json",
  },
  pageLength: 10,
  lengthMenu: [5, 10, 25, 50],
  columns: [null, null, null, null, null, null, null, null, { orderable: false }],
});