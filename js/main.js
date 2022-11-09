function prikaziUgovore() {
    var x = document.getElementById("pregled");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

$("#btn-dodaj-psa").submit(function () {
    $("modalDodavanjePsa").modal("toggle");
    return false;
});

$("#btn-dodaj-udomitelja").submit(function () {
    $("modalDodavanjeUdomitelja").modal("toggle");
    return false;
});

$("#btn-dodaj-ugovor").submit(function () {
    $("modalDodavanjeUgovora").modal("toggle");
    return false;
});

$("#btn-izmeni-ugovor").submit(function () {
    $("modalIzmenaUgovora").modal("toggle");
    return false;
});
$(document).ready(function () {
    $("#dodaj-form-pas").submit(function () {
        event.preventDefault();

        const $form = $(this);
        const $inputs = $form.find("input, select, button");
        const serializedData = $form.serialize();
        console.log(serializedData);
        let obj = $form.serializeArray().reduce(function (json, {name, value}) {
            json[name] = value;
            return json;
        }, {});
        console.log(obj);
        $inputs.prop("disabled", true);

        request = $.ajax({
            url: "handler/addPas.php",
            type: "post",
            data: serializedData,
        });

        request.done(function (response, textStatus, jqXHR) {
            if (response === "Success") {
                alert("Pas je dodat");
            } else console.log("Pas nije dodat " + response);
            console.log(response);
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            console.error("The following error occurred: " + textStatus, errorThrown);
        });
    });

    $("#dodaj-form-udomitelj").submit(function () {
        event.preventDefault();

        const $form = $(this);
        const $inputs = $form.find("input, select, button");
        const serializedData = $form.serialize();
        console.log(serializedData);
        let obj = $form.serializeArray().reduce(function (json, {name, value}) {
            json[name] = value;
            return json;
        }, {});
        console.log(obj);
        $inputs.prop("disabled", true);

        request = $.ajax({
            url: "handler/addUdomitelj.php",
            type: "post",
            data: serializedData,
        });

        request.done(function (response, textStatus, jqXHR) {
            if (response === "Success") {
                alert("Udomitelj je dodat");
            } else console.log("Udomitelj nije dodat " + response);
            console.log(response);
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            console.error("The following error occurred: " + textStatus, errorThrown);
        });
    });

    $("#dodaj-form-ugovor").submit(function () {
        event.preventDefault();

        const $form = $(this);
        const $inputs = $form.find("input, select, button");
        const serializedData = $form.serialize();
        console.log(serializedData);
        let obj = $form.serializeArray().reduce(function (json, {name, value}) {
            json[name] = value;
            return json;
        }, {});
        console.log(obj);
        $inputs.prop("disabled", true);

        request = $.ajax({
            url: "handler/addUgovor.php",
            type: "post",
            data: serializedData,
        });

        request.done(function (response, textStatus, jqXHR) {
            if (response === "Success") {
                alert("Ugovor je dodat");
                appandRow(obj);
            } else console.log("Ugovor nije dodat " + response);
            console.log(response);
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            console.error("The following error occurred: " + textStatus, errorThrown);
        });
    });

    $("#btn-izmeni-ugovor").click(function () {
        const checked = $("input[name=checked-donut]:checked");

        request = $.ajax({
            url: "handler/getUgovor.php",
            type: "post",
            data: { id: checked.val() },
            dataType: "json",
        });

        request.done(function (response, textStatus, jqXHR) {
            console.log("Popunjena");
            $("#ugovor-id").val(response[0]["id"]);
            console.log(response[0]["id"]);
            if (response[0]["potpisano"] === 1) {
                $("#ugovor-potpisano").val(checked.val());
            } else {
                $("#ugovor-potpisano").val(0);
            }
            console.log(response[0]["potpisano"]);
            var dateSplit = response[0]["datum_potpisa"].split('-');
            $("#ugovor-datum").val(Date(dateSplit[2], dateSplit[1] - 1, dateSplit[0]));
            console.log(response[0]["datum_potpisa"].trim());

            $("#ugovor-pas-id").val(response[0]["pas_id"].trim());
            console.log(response[0]["pas_id"].trim());
            $("#ugovor-udomitelj-id").val(response[0]["udomitelj_id"].trim());
            console.log(response[0]["udomitelj_id"].trim());

            console.log(response);
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            console.error("The following error occurred: " + textStatus, errorThrown);
        });
    });

    $("#izmeni-form-ugovor").submit(function () {
        event.preventDefault();
        console.log("Izmena");
        const $form = $(this);
        const $inputs = $form.find("input, select, button");
        const serializedData = $form.serialize();
        console.log(serializedData);
        let obj = $form.serializeArray().reduce(function (json, { name, value }) {
            json[name] = value;
            return json;
        }, {});
        console.log(obj);
        $inputs.prop("disabled", true);

        request = $.ajax({
            url: "handler/updateUgovor.php",
            type: "post",
            data: serializedData,
        });

        request.done(function (response, textStatus, jqXHR) {
            if (response === "Success") {
                console.log("Ugovor je izmenjen");
                updateRow(obj);
            } else console.log("Ugovor nije izmenjen " + response);
            console.log(response);
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            console.error("The following error occurred: " + textStatus, errorThrown);
        });
    });
});

function updateRow(obj) {
    console.log(obj);
    console.log(obj.id);
    console.log($(`#tabela tbody #tr-${obj.id} td`).get());
    let tds = $(`#tabela tbody #tr-${obj.id} td`).get();

    tds[1].textContent = obj.potpisano;
    tds[2].textContent = obj.datum_potpisa;
    tds[3].textContent = obj.pas_id;
    tds[4].textContent = obj.udomitelj_id;
}

function appandRow(obj) {
    console.log(obj);

    $.get("handler/getLastElement.php", function (data) {
        console.log(data);
        console.log($("#tabela tbody tr:last").get());
        $("#tabela tbody").append(`
      <tr>
          <td>${data}</td>
          <td>${obj.nazivTima}</td>
          <td>${obj.drzava}</td>
          <td>${obj.godinaOsnivanja}</td>
          <td>${obj.brojTitula}</td>
          <td>
              <label class="custom-radio-btn">
                  <input type="radio" name="checked-donut" value=${data}>
                  <span class="checkmark"></span>
              </label>
          </td>
      </tr>
    `);
    });
}

function pretrazi() {

    var input, filter, table, tr, i, td1, td2, td3, td4, td5, txtValue1, txtValue2, txtValue3, txtValue4;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("tabela");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td1 = tr[i].getElementsByTagName("td")[1];
        td2 = tr[i].getElementsByTagName("td")[2];
        td3 = tr[i].getElementsByTagName("td")[3];
        td4 = tr[i].getElementsByTagName("td")[4];
        td5 = tr[i].getElementsByTagName("td")[5];

        if (td1 || td2 || td3 || td4 || td5) {
            txtValue1 = td1.textContent || td1.innerText;
            txtValue2 = td2.textContent || td2.innerText;
            txtValue3 = td3.textContent || td3.innerText;
            txtValue4 = td4.textContent || td4.innerText;
            txtValue5 = td5.textContent || td5.innerText;

            if (txtValue1.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1 ||
                txtValue3.toUpperCase().indexOf(filter) > -1 || txtValue4.toUpperCase().indexOf(filter) > -1 ||
                txtValue5.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

function sortTable() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("tabela");
    switching = true;
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[2];
            y = rows[i + 1].getElementsByTagName("TD")[2];
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}