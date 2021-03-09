var cal = {
 
  ajax : function (data, load) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "calendar-ajax.php");
    if (load) { xhr.onload = load; }
    xhr.send(data);
  },

  init : function () {
    document.getElementById("calmonth").addEventListener("change", cal.draw);
    document.getElementById("calyear").addEventListener("change", cal.draw);
    document.getElementById("calformdel").addEventListener("click", cal.del);
    document.getElementById("calform").addEventListener("submit", cal.save);
    document.getElementById("calformcx").addEventListener("click", cal.hide);
    cal.draw();
  },

  draw : function () {
   
    let data = new FormData();
    data.append("req", "draw");
    data.append("month", document.getElementById("calmonth").value);
    data.append("year", document.getElementById("calyear").value);

    cal.ajax(data, function(){
      let wrapper = document.getElementById("calwrap");
      wrapper.innerHTML = this.response;
      let all = wrapper.getElementsByClassName('day');
      for (let day of all) {
        day.addEventListener("click", cal.show);
      }
      all = wrapper.getElementsByClassName('calevt');
      if (all.length != 0) { for (let evt of all) {
        evt.addEventListener("click", cal.show);
      }}
    });
  },
  
  show : function (evt) {
    let eid = this.getAttribute("data-eid");
  
    if (eid === null) {
      let year = document.getElementById("calyear").value,
          month = document.getElementById("calmonth").value,
          day = this.dataset.day;
      if (month.length==1) { month = "0" + month; }
      if (day.length==1) { day = "0" + day; }
      document.getElementById("calform").reset();
      document.getElementById("evtstart").value = `${year}-${month}-${day}`;
      document.getElementById("calformdel").style.display = "none";
    }

    else {
      let edata = JSON.parse(document.getElementById("evt"+eid).innerHTML);
      document.getElementById("evtid").value = eid;
      document.getElementById("evtstart").value = edata['evt_start'];
      document.getElementById("evtend").value = edata['evt_end'];
      document.getElementById("evttxt").value = edata['evt_text'];
      document.getElementById("evtcolor").value = edata['evt_color'];
      document.getElementById("calformdel").style.display = "block";
    }

    document.getElementById("calblock").classList.add("show");
    evt.stopPropagation();
  },
  
  hide : function () {
    document.getElementById("calblock").classList.remove("show");
  },
  
  save : function (evt) {
 
    let data = new FormData(),
        eid = document.getElementById("evtid").value;
    data.append("req", "save");
    data.append("start", document.getElementById("evtstart").value);
    data.append("end", document.getElementById("evtend").value);
    data.append("txt", document.getElementById("evttxt").value);
    data.append("color", document.getElementById("evtcolor").value);
    if (eid!="") { data.append("eid", eid); }

    cal.ajax(data, function(){
      if (this.response=="OK") { cal.hide(); cal.draw(); }
      else { alert(this.response); }
    });
    evt.preventDefault();
  },

  del : function () { if (confirm("Delete Event?")) {
    let data = new FormData();
    data.append("req", "del");
    data.append("eid", document.getElementById("evtid").value);
    
    cal.ajax(data, function(){
      if (this.response=="OK") { cal.hide(); cal.draw(); }
      else { alert(this.response); }
    });
  }}
};
window.addEventListener("DOMContentLoaded", cal.init);