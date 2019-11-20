/* Purkiáda API Interface */

var API = {
  endpoint: "https://admin.purkiada.cz/api",

  getVillages: function () {
    return $.get(this.endpoint+"/village/list", {}, "json");
  },

  getSchools: function (villageID) {
    return $.get(this.endpoint+"/school/find", {village: villageID}, "json");
  },

  submitStudent: function (data) {
    return $.post(this.endpoint+"/student/new", data, "json");
  },

  confirmStudent: function (data) {
    return $.get(`${this.endpoint}/student/confirm`, data, "json");
  },
}
