<?php 

//var_dump($data);

?>

<select id="postal">
    <option value="-1">Izaberi</option>
    <?php foreach($data as $postal){
        echo "<option value='{$postal->postal}'>{$postal->postal}</option>";
    } ?>
</select>
<br><br>
<form id="frm">
<label> City </label><br>
<input name="city" id="city" value=""><br>
<label> Latitude </label><br>
<input name="latitude" id="latitude" value=""><br>
<label> Longitude </label><br>
<input name="longitude" id="longitude" value=""><br>
<label> Region iso </label><br>
<input name="region_iso" id="region_iso" value=""><br>
<label> Region name </label><br>
<input name="region_name" id="region_name" value=""><br>
<label id="lbl_postal" style="display: none;"> Postal code </label>
<input style="display: none;" name="input_postal" id="input_postal" value=""><br>
<input type="hidden" name="id" id="id" value="">
<button id="insert" type="button">Insert</button>
<button id="update" type="button">Update</button>
<button id="delete" type="button">Delete</button>
<button id="reset" type="button" onclick="clearFields();">Reset fields</button>
</form>
<br>
<form id="search_form"> 
    <label>Postal code:</label>
    <input type="text" id="postal_search" name="postal_search">
    <button type="button" id="search">Search</button>
</form>
<script>
    $(document).ready(function(){
        $('#insert').attr('disabled','disabled');
    });
    $('#search').click(function(){
        if($('#postal_search').val() ===''){
            alert('Unesite postal code!');
        }else{
        request = $.ajax({
            url: "index.php?controller=home&method=search",
            type: "post",
            dataType: 'json',
            data: $('#search_form').serialize(),
            success: function(response){
                if(response.error === false){
                    alert("latitude:"+response.postal[0].latitude+"\r\n longitude:"+response.postal[0].longitude);
                }else{
                    alert(response.message);
                }
            }   
        });
    }
    });
    function rednerContent(response){
       if(response.error === false){
       $('#city').val(response.postals[0].city);
       $('#latitude').val(response.postals[0].latitude);
       $('#longitude').val(response.postals[0].longitude);
       $('#region_iso').val(response.postals[0].region_iso);
       $('#region_name').val(response.postals[0].region_name);
       $('#id').val(response.postals[0].id);
       $('#update').removeAttr('disabled');
       $('#delete').removeAttr('disabled');
       $('#input_postal').css('display','none');
       $('#lbl_postal').css('display','none');
        }else{
            
        }
       console.log(response);
    }
    function clearFields(form = 0){
       $('#city').val('');
       $('#latitude').val('');
       $('#longitude').val('');
       $('#region_iso').val('');
       $('#region_name').val('');
       $('#update').attr('disabled','disabled');
       $('#delete').attr('disabled','disabled');
        $('#insert').removeAttr('disabled','disabled');
       if(form == 0){
        $('#input_postal').css('display','block');
        $('#lbl_postal').css('display','block');
    }
    }
    $("#postal").change(function(){
        request = $.ajax({
            url: "index.php?controller=home&method=loadData",
            type: "post",
            dataType: 'json',
            data: "region="+$(this).val(),
            success: function(response){
                rednerContent(response);
                $('#insert').attr('disabled','disabled');
            }   
        });
    });
    $('#update').click(function(){
        request = $.ajax({
            url: "index.php?controller=home&method=update",
            type: "post",
            dataType: 'json',
            data: $('#frm').serialize(),
            success: function(response){
                alert(response.message);
            }   
        });
    });
    
      $('#insert').click(function(){
        request = $.ajax({
            url: "index.php?controller=home&method=insert",
            type: "post",
            dataType: 'json',
            data: $('#frm').serialize(),
            success: function(response){
                 clearFields(1);
                alert(response.message);
                location.reload();
            }   
        });
    });
    
    $('#delete').click(function(){
        var id = $('#id').val();
        request = $.ajax({
            url: "index.php?controller=home&method=delete",
            type: "post",
            dataType: 'json',
            data: {id: id},
            success: function(response){
                alert(response.message);
                clearFields(1);
               location.reload();
            }   
        });
    });
</script>


