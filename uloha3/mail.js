



$("#skFlag").click(function() {
changeLanguage("sk");
});

$("#ukFlag").click(function(){
changeLanguage("en");
});


$("#resetPreset").click(function(){
 loadPreset();
});

function changeLanguage(language){

    $.ajax({
        type: "POST",
        url: 'https://147.175.121.210:4472/cvicenia/projekt/uloha3/mailApi.php/changeLanguage',
        data:"&language=" + language,
        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
        success: function(msg){

            location.reload();
            
        }
    });
}

function loadPreset(){

    $.ajax({
        type: "GET",
        url: 'https://147.175.121.210:4472/cvicenia/projekt/uloha3/mailApi.php/getEmailPreset',
        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
        success: function(msg)
        {
          
            $("#formObsah").val(msg);
            tinyMCE.activeEditor.setContent(msg);
        }});


}

function loadHistory(){

    $.ajax({
        type: "GET",
        url: 'https://147.175.121.210:4472/cvicenia/projekt/uloha3/mailApi.php/getHistory',
        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
        success: function(msg)
        {

            $("#tableBody").val('');

            var obj = JSON.parse(msg);
            for(var i in obj['table']){
                
                let datum = obj['table'][i]['datum'];
                let meno = obj['table'][i]['meno'];
                let nazov = obj['table'][i]['nazov'];

                //console.log(datum);
                let row = $('<tr></tr>');

                let data1 = $('<td></td>');
                data1.append(datum);
                let data2 = $('<td></td>');
                data2.append(meno);
                let data3 = $('<td></td>');
                data3.append(nazov);

                row.append(data1);
                row.append(data2);
                row.append(data3);

                $('#tableBody').append(row);

            }
        
            $('#dtBasicExample').DataTable({
                searching: false
            });

        }});


}

$("#upload1Form").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr('action');

    var formData = new FormData();

    var fileSelect = document.getElementById("subor1");
    if(fileSelect.files && fileSelect.files.length == 1){
    var file = fileSelect.files[0];
    formData.append("file", file,file.name);
    }
    formData.append("separator",document.getElementById("idecko2").value);

    // console.log(formData.get('file'));
    // console.log(formData.get('separator'));

    $.ajax({
        type: "POST",
        url: url,
        processData: false,
        contentType: false,
        data: formData,
        success: function(data){

            if ($.trim(data) == "SUCCESS"){



            var anchor=document.createElement('a');
    	    anchor.setAttribute('href','file.csv');
    	    anchor.setAttribute('download','');
    	    document.body.appendChild(anchor);
    	    anchor.click();
            anchor.parentNode.removeChild(anchor);

            $('#hlaska1').remove();

            var text = $('<p></p>');
            text.attr('id','hlaska1');
            text.attr('class','hlasky');
            
            var sessionValue = '<%=Session["language"]%>'
            console.log(sessionValue);

            console.log($('#firstSubtitle').html());
            if($('#firstSubtitle').html() == "Generovanie a odosielanie prístupových údajov"){
                text.append("Heslá úspešne pridané. Súbor sa automaticky stiahne");
            } else {
                text.append("Passwords successfully added. File is being downloaded");
            }

            $('#generateFormDiv').append(text);
            } else {

            }

            

            ///}

        }

}); 

});

$("#upload2Form").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr('action');

    var formData = new FormData();

    ///CSV FILE
    var fileSelect = document.getElementById("subor2");
    if(fileSelect.files && fileSelect.files.length == 1){
    var file = fileSelect.files[0];
    formData.append("file", file,file.name);
    }

    //SEPARATOR
    formData.append("separator",document.getElementById("separator2").value);

    //TITLE
    formData.append("title",document.getElementById("formNazov").value);

    //NAME
    formData.append("name",document.getElementById("formMeno").value);

    //EMAIL
    formData.append("email",document.getElementById("formEmail").value);

    //PASSWORD
    formData.append("password",document.getElementById("formHeslo").value);

    //EXTENSION
    var fileSelect = document.getElementById("subor3");
    if(fileSelect.files && fileSelect.files.length == 1){
        var file = fileSelect.files[0];
        formData.append("extension", file,file.name);
        }

    //EMAIL CONTENT
    if($('#customSwitches').is(":checked")){
        formData.append("content",tinymce.activeEditor.getContent());
        formData.append("isHTML",true);
     } else {
         formData.append("content",tinymce.activeEditor.getContent({format : 'text'}));
         formData.append("isHTML",false);
     }

    var kolecko = $('<div class="lds-spinner" id ="kolecko"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>');
    $('#dbLoginCollapse2').append(kolecko);

    $('#hlaska2').remove();

    $.ajax({
        type: "POST",
        url: url,
        processData: false,
        contentType: false,
        data: formData,
        success: function(data){

            $('#kolecko').remove();

            console.log(data);

            $('#hlaska2').remove();

            var text = $('<p></p>');
            text.attr('id','hlaska2');
            text.attr('class','hlasky');
            
            var sessionValue = '<%=Session["language"]%>'
            console.log(sessionValue);

            console.log($('#firstSubtitle').html());
            if($('#firstSubtitle').html() == "Generovanie a odosielanie prístupových údajov"){
                text.append("Emaili boli úspešne odoslané");
            } else {
                text.append("Emails were successfully sent");
            }

            $('#generateFormDiv2').append(text);
        
        }
    });


});


$(document).ready(function(){
    loadPreset();
    loadHistory();
});