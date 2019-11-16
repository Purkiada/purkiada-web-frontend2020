/* Purkiáda API Interface */

var API = {
  endpoint: "https://purkiada.purkynkalife.cz/api",

  getVillages: function () {
    return $.get(this.endpoint+"/village/list", {}, "json");
  },

  getSchools: function (villageID) {
    return $.get(this.endpoint+"/school/find", {village: villageID}, "json");
  },

  submitStudent: function (data) {
    return $.post(this.endpoint+"/student/new", data, "json");
  },
}
