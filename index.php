<!DOCTYPE html>
<?php
/*
This mutation calculator was designed to quickly calculate the change
in information content of a specified variant. It also returns the
number of studies in which this variant has been reported following
our literature review. 
Copyright (C) 2014 Cytognomix Inc.
   
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.
   
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
   
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software Foundation,
Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301  USA
*/
?>
<html>
  <head>
	<meta name="author" content="Cytognomix Inc.">
    <title>Splicing Mutation Calculator</title>
	<link rel="stylesheet" type="text/css" href="./css/stickyfooter.css">
    <script type="text/javascript" language="javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" language="javascript" src="http://cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
    <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
	<link href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/smc.css">

</head>
  <body>
<?php 
	include("./templates/calc_footer.php"); 
?>
    <h1 class="text-center">Mutation Calculator</h1>
    <div class="container">
    	<p class="text-center">
			This mutation calculator was designed to quickly calculate the &#916<em>R<sub>i</sub></em> of a specified variant. It also returns the number of studies in which this variant has been reported following our literature review. Details on these papers can be found in the source table, which appears as a link following variant submission. To view the source table in its entirety, please click <a target="_blank" href="./ref_table.php">here</a>.
    	</p>
    <table id="steps" align="center">
      <tr>
	<td colspan="2">
	  <h3 class="text-center"><b>Step 1</b>: Select type of site and position</h3>
	  <p class="instructions text-center">
	    Select a splice site type (acceptor or donor) by clicking on the sequence logo. The sequence logo will become coloured and a purple slider bar will appear. Use this slider to select a position.
	  </p>
	</td>
      </tr>
      <tr>
	<td>
	  <img id="acceptorimg" class="unselectedLogo" src="./images/acceptor_gy.jpg"/>
	</td>
	<td>
	  <img id="donorimg" class="unselectedLogo" src="./images/donor_gy.jpg"/>
	</td>
      </tr>
      <tr>
	<td>
	  <div id="slider1"></div>
	</td>
	<td>
	  <div id="slider2"></div>
	</td>
      </tr>
	  
      <tr>
	<td>
	    <label class="acceptorlocation">Acceptor Location:</label>
	    <input type="text" class="acceptorlocation" id="acceptorlocation" readonly>
	</td>
	<td>
	    <label class="donorlocation">Donor Location:</label>
	    <input type="text" class="donorlocation" id="donorlocation" readonly>
	</td>
     </tr>
	 </table>

	 <div class="row text-center">
		<h3><b>Step 2</b>: Select both reference and mutant nucleotides</h3>
		
			<label for="refNucGroup">Reference</label>
			<div name="refNucGroup" id="refNucGroup" class="refNuc btn-group" data-toggle="buttons">
				<label class="btn btn-default">
				<input type="radio" name="refNucRadioGroup" value="A" class="btn btn-default unselected a">A
				</label>
				<label class="btn btn-default">
				<input type="radio" name="refNucRadioGroup" value="G" class="btn btn-default unselected g">G
				</label>
				<label class="btn btn-default">
				<input type="radio" name="refNucRadioGroup" value="C" class="btn btn-default unselected c">C
				</label>
				<label class="btn btn-default">
				<input type="radio" name="refNucRadioGroup" value="T" class="btn btn-default unselected t">T
				</label>
			</div>

			<label style="margin-left:50px;" for="mutNucGroup">Mutant</label>
			<div name="mutNucGroup" id="mutNucGroup" class="mutNuc btn-group" data-toggle="buttons">
			<label class="btn btn-default">
				<input type="radio" name="altNucRadioGroup" value="A" class="btn btn-default unselected a">A
			</label>
			<label class="btn btn-default">
				<input type="radio" name="altNucRadioGroup" value="G" class="btn btn-default unselected g">G
			</label>
			<label class="btn btn-default">
				<input type="radio" name="altNucRadioGroup" value="C" class="btn btn-default unselected c">C
			</label>
			<label class="btn btn-default">
				<input type="radio" name="altNucRadioGroup" value="T" class="btn btn-default unselected t">T
			</label>
			</div>
	</div>
    <div style="margin-top:20px;" class="row text-center">
		<button style="margin-bottom:10px;" type="button" class="btn btn-primary" id="executeButton" name="executeButton">Submit your selections</button>
    </div>
	<div id="error"></div>

    <table class="resultsTable" id="results_0">
      <tr>
	<td> Variant </td>
	<td> <span class="resultsTableVariant"></span> </td>
      </tr>
      <tr>
	 <td> Number of times variant was documented in liturature review </td>
	 <td> Not documented </td>
      </tr>
	  <tr id="calculatedRiTableData1997">
	 <td> Computationally derived &#916<em>R<sub>i</sub></em> value (1997 Ribl)</td>
	  <td class="ri"><span id="ri1997"></span> bits.<br>
      </tr>
      <tr>
	  <td> Computationally derived &#916<em>R<sub>i</sub></em> value (2003 Ribl)</td>
	  <td class="ri"> <span id="calcRi1"></span> bits</td>
      </tr>
    </table>
    <table class="resultsTable" id="results_1">
	<td> Variant </td>
	<td> <span class="resultsTableVariant"></span> </td>
      <tr>
	 <td> Number of times variant was documented in literature review </td>
	 <td><span id="count"></span>
	 </td>
      </tr>
      <tr>
	 <td> Computationally derived &#916<em>R<sub>i</sub></em> value found in these studies (1997 Ribl)</td>
	  <td class="ri"><span id="exRi"></span> bits.<br>
      </tr>
	  <tr id="calculatedRiTableData">
	  <td> Computationally derived &#916<em>R<sub>i</sub></em> value (2003 Ribl)</td>
	  <td class="ri"><span id="calculatedRi"></span> bits</td>
      </tr>
    </table>
    <span id="refTable"></span>
    <br>
    <table id="Legend_table" cellSpacing="1" cellPadding="1" border="1">
      <tr>
	<td vAlign="up" width="95" bgColor="#ffffff"><font size="2"><b>Legend:</b></font></td>
	<td width="23" bgColor="#ff2d2d" height="10" valign="bottom" data-toggle="tooltip" data-placement="top" title="&#916;<em>R<sub>i</sub></em> &#60; -7.0">&nbsp;</td>
	<td height="10" width="95" valign="bottom" data-toggle="tooltip" data-placement="top" title="&#916;<em>R<sub>i</sub></em> &#60; -7.0"><font size="2">&nbsp;Deleterious</font></td>
	<td width="23" bgColor="#8080ff" height="10" valign="bottom" data-toggle="tooltip" data-placement="top" title="&#916;<em>R<sub>i</sub></em> &#60; -4.0 and &#916;<em>R<sub>i</sub></em> &#62; -7.0">&nbsp;</td>
	<td width="130" height="10" valign="bottom"><font size="2" data-toggle="tooltip" data-placement="top" title="&#916;<em>R<sub>i</sub></em> &#60; -4.0 and &#916;<em>R<sub>i</sub></em> &#62; -7.0">Probable Deleterious</font></td>
	<td width="23" height="10" bgcolor="#B3FFE7" valign="bottom" data-toggle="tooltip" data-placement="top" title="&#916;<em>R<sub>i</sub></em> &#60; -1.0 and &#916;<em>R<sub>i</sub></em> &#62; -4.0">&nbsp;</td>
	<td width="95" height="10" valign="bottom"><font size="2" data-toggle="tooltip" data-placement="top" title="&#916;<em>R<sub>i</sub></em> &#60; -1.0 and &#916;<em>R<sub>i</sub></em> &#62; -4.0">Leaky</font></td>
	<td width="23" height="10" bgcolor="#66FF66" valign="bottom" data-toggle="tooltip" data-placement="top" title="&#916;<em>R<sub>i</sub></em> &#8805; -1.0">&nbsp;</td>
	<td width="200" height="10" valign="bottom" data-toggle="tooltip" data-placement="top" title="&#916;<em>R<sub>i</sub></em> &#8805; -1.0"><font size="2">Benign, polymorphism probable</font></td>
      </tr>
    </table>
		<div class="footnotes" style="margin-bottom:50px;padding-bottom:10px;" align="center">
	  The above splice site sequence logos can be found in <a href="Rogan-2003.pdf" target="_blank"> Rogan et al. 2003</a>.  
    </div>
</div>


    <script>
      $(document).ready(function() {
	  
	$("#results_0").hide();
	$("#results_1").hide();
	$("#slider1").hide();
	$("#slider2").hide();
	$(".acceptorlocation").hide();
	$(".donorlocation").hide();
	$("#Legend_table").hide();
	
	$('body').tooltip({
				selector: '[data-toggle=tooltip]',
                show: null,
                html: true,
                container: 'body',

                open: function( event, ui ) {
                        ui.tooltip.animate({ top: ui.tooltip.position().top + 10 }, "fast" );
                }
        });
	

	var spliceSiteType 	= null;
	var refNuc 		= null;
 
	//acceptor slider
	$( "#slider1" ).slider({
	  value:1,
	  min: -25,		//this value corresponds to -26 on the acceptor logo because the logo does not have a 0 position
	  max: 2,
	  step: 1,
	  slide: function( event, ui ) {
	    var loc = ui.value	//the current position of the slider
	    if(loc<1){
	      loc--;		//adjust for removed zero position
	    }
	    $( "#acceptorlocation" ).val(loc);
	  }
	});

	$( "#acceptorlocation" ).val($( "#slider1" ).slider( "value" ) );
    	
	//donor slider
	$( "#slider2").slider({
	  value:1,
	  min: -3,
	  max: 6,		//this value corresponds to 7 on the donor logo because the logo does not have a 0 position
	  step: 1,
	  slide: function( event, ui ) {
	    var loc = ui.value	//the current position of the slider
	    if(loc>-1){
	      loc++;		//adjust for removed zero position
	    }
	  $( "#donorlocation" ).val(loc);
	  }
	});

	$("#donorlocation").val($( "#slider2" ).slider( "value" ));
       
	//upon clicking a logo it is selected/deselcedted and the other logo is deselected/selected 
	$("#acceptorimg").click(function(){

	 if($("#acceptorimg").attr("src")=="./images/acceptor_gy.jpg"){
	   $("#acceptorimg").attr("src", "./images/acceptor.jpg");
	   $("#acceptorimg").removeClass("unselectedLogo");
	   $("#donorimg").attr("src", "./images/donor_gy.jpg");
	   $("#donorimg").addClass("unselectedLogo")
	   spliceSiteType="Acceptor";
	   $("#slider1").show();
	   $(".acceptorlocation").show();
	   $("#slider2").hide();
	   $(".donorlocation").hide();
	   }

	 else{
	   $("#acceptorimg").attr("src", "./images/acceptor_gy.jpg");
	   $("#acceptorimg").addClass("unselectedLogo");
	   $("#donorimg").attr("src", "./images/donor.jpg");
	   $("#donorimg").removeClass("unselectedLogo");
	   spliceSiteType="Donor";
	   $("#slider2").show();
	   $(".donorlocation").show();
	   spliceSiteType="Donor"
	   $("#slider1").hide();
	   $(".acceptorlocation").hide();
	   }
	  
	});

	$("#donorimg").click(function(){

	 if($("#donorimg").attr("src")=="./images/donor_gy.jpg"){
	   $("#donorimg").attr("src", "./images/donor.jpg");
	   $("#donorimg").removeClass("unselectedLogo");
	   $("#acceptorimg").attr("src","./images/acceptor_gy.jpg");
	   $("#acceptorimg").addClass("unselectedLogo");
	   spliceSiteType="Donor";
	   $("#slider2").show();
	   $(".donorlocation").show();
	   spliceSiteType="Donor"
	   $("#slider1").hide();
	   $(".acceptorlocation").hide();
	   }

	 else{
	   $("#acceptorimg").attr("src", "./images/acceptor.jpg");
	   $("#acceptorimg").removeClass("unselectedLogo");
	   $("#donorimg").attr("src", "./images/donor_gy.jpg");
	   $("#donorimg").addClass("unselectedLogo")
	   spliceSiteType="Acceptor";
	   $("#slider1").show();
	   $(".acceptorlocation").show();
	   $("#slider2").hide();
	   $(".donorlocation").hide();
	   }

	});	

	//nucleotides are selected upon being clicked
	$(".refNuc .unselected").click(function(){
	  $(".refNuc .selected").removeClass("selected").addClass("unselected");
	  $(this).addClass("selected").removeClass("unselected");
	  $("#refNuc").html($(this).text());
	});

	$(".mutNuc .unselected").click(function(){
	  $(".mutNuc .selected").removeClass("selected").addClass("unselected");
	  $(this).addClass("selected").removeClass("unselected");
	  $("#mutNuc").html($(this).text());
	});

	$("#executeButton").click( function(){
	  executeCalculator();     
      	});

	
	
	function executeCalculator() {
	  var terminate 	= false;			//calculator terminates if there are errors in user input
	  var refNuc = "";
		var selected = $("input[type='radio'][name='refNucRadioGroup']:checked");
		if (selected.length > 0) {
			refNuc = selected.val();
		}
	var altNuc = "";
		var selected = $("input[type='radio'][name='altNucRadioGroup']:checked");
		if (selected.length > 0) {
			altNuc = selected.val();
		}
	  
	  
	  var spliceSitePos 	= $('#acceptorlocation').val();
	  var spliceSitePosRef	= $('#acceptorlocation').val();
	  
	  
	  $("#error").hide();


	  //increases the location value we send by 1 if the location type is acceptor
	  if(spliceSiteType=="Acceptor"){
	    if(spliceSitePos<1){
	      spliceSitePos++;
	    }
	  }

	  //reduces the location value we send by 1 if the location type is donor
	  if(spliceSiteType=="Donor"){
	    spliceSitePosRef=$('#donorlocation').val();
	    spliceSitePos=$('#donorlocation').val();
	    if(spliceSitePos>-1){
	      spliceSitePos--;
	    }
	  }

	  //tests if the user has selected a location
	  if(spliceSiteType==null){
	    
	    terminate 		= true;
	    $("#error").html("Select a splice site location by clicking on the logo and sliding the arrow to the location of the mutation.");
	    $("#error").show();
	    $("#results_0").hide();
	    $("#results_1").hide();
		$("#Legend_table").hide();
	  }

	  //this id is used to search the table
	  var tableID		= spliceSiteType.toLowerCase()+spliceSitePos+refNuc+">"+altNuc;

	  //tests if a reference nucleotide has been selected
	  if(terminate==false){
	    if(!refNuc){
	      terminate 	= true;
	      $("#error").html("Select a reference nucleotide.");
	      $("#error").show();
	      $("#results_0").hide();
	      $("#results_1").hide();
		  $("#Legend_table").hide();
	    }
	  }

	  //tests if a mutant nucleotide has been selected
	  if(terminate==false){
	    if(!altNuc){
	      terminate		=true;
	      $("#error").html("Select a mutant nucleotide.");
	      $("#error").show();
	      $("#results_0").hide();
	      $("#results_1").hide();
		  $("#Legend_table").hide();
	    }
	  }
	  
	  //tests if the reference nucleotide and the mutant nucleotide are different
	  if(terminate==false){
	    if(refNuc==altNuc){
	      terminate	=true;
	      $("#error").html("Select a mutant nucleotide different from the reference nucleotide.");
	      $("#error").show();
	      $("#results_0").hide();
	      $("#results_1").hide();
		  $("#Legend_table").hide();
	    }
	  }

	  if(terminate==false){
	    //send information to calculator
		var calcRi1997 = 0;
	    $.ajax({
	      type: "POST",
	      url: "./ajax/calc.php",
	      async: false,
	      data: {"spliceSitePos":spliceSitePos, "refNuc":refNuc, "altNuc":altNuc, "spliceSiteType":spliceSiteType},
	      success: function(data){
		var test 		= $.parseJSON(data);
		var exRi 		= test["RiExperimental"];
		var riblRi		= test["RiFromRibl"];
		var count		= test["Count"];

			var spliceSiteTypeOld = spliceSiteType + '_OLD';
			
			$.ajax({
	      type: "POST",
	      url: "./ajax/calc.php",
	      async: false,
	      data: {"spliceSitePos":spliceSitePos, "refNuc":refNuc, "altNuc":altNuc, "spliceSiteType":spliceSiteTypeOld},
	      success: function(data){
			var test 		= $.parseJSON(data);
			calcRi1997		= test["RiFromRibl"];
		  }
		  });
		
		//results when this mutation has not been reported in literature review
		if(count==0){
			
		  $("#refTable").hide();
		  $("#results_1").hide();
		  $("#results_0").fadeOut(400,function(){
		  $("#ri1997").html(calcRi1997);
		  $("#calcRi1").html(riblRi);
		  $("#count").html(count);
		  $(".resultsTableVariant").html(refNuc+">"+altNuc+" at "+spliceSiteType+" "+spliceSitePosRef)
		  
		  //determine type of mutation from ri
		  $(".ri").each(function(){

		    var ri = $("span", this).text();

		    if(ri<-7){
		      $(this).addClass("deleterious");
		      $(this).attr({title:"This is a deleterious mutation"});
		      $(this).removeClass("probDel");
		      $(this).removeClass("leaky");
		      $(this).removeClass("benign");
		    }
		    else if(ri<-4){
			$(this).addClass("probDel");
			$(this).attr({title:"It is probable that this is a deletreious mutation"});
			$(this).removeClass("leaky");
			$(this).removeClass("benign");
			$(this).removeClass("deleterious");
		    }
		    else if(ri<-1){
			$(this).addClass("leaky");
			$(this).attr({title:"This is a leaky mutation"});
    			$(this).removeClass("probDel");
			$(this).removeClass("benign");
			$(this).removeClass("deleterious");
		    }
		    else {
			$(this).addClass("benign");
			$(this).attr({title:"This is a benign mutation. Polymorphism is probable."});
    		$(this).removeClass("probDel");
			$(this).removeClass("leaky");
			$(this).removeClass("deleterious");
		  }
		  });
		  $("#results_0").fadeIn(400);
		  $("#Legend_table").fadeIn(400);
		  });

		}

		//results when the variant has been found in the literature review
		else{
		  $("#results_0").hide();
		  $("#results_1").fadeOut(400,function(){;
		  $("#calculatedRi").html(riblRi);
		  $("#count").html(count);
		  $("#exRi").html(exRi);
		  $("#refTable").html('<div style="margin-top:10px;" class="text-center"><a href="ref_table.php?searchterm='+tableID+'" target="_blank"><div class="btn btn-primary" id="refTableButton">View the above variant(s) in source table</div></a></div>');
		  $(".resultsTableVariant").html(refNuc+">"+altNuc+" at "+spliceSiteType+" "+spliceSitePosRef)
		  $(".ri").each(function(){
		    var ri = $("span", this).text();
		    if(ri<-7){
		      $(this).addClass("deleterious");
		      $(this).attr({title:"This is a deleterious mutation"});
		      $(this).removeClass("probDel");
		      $(this).removeClass("leaky");
		      $(this).removeClass("benign");
		    }
		    else if(ri<-4){
			$(this).addClass("probDel");
			$(this).attr({title:"It is probable that this is a deletreious mutation"});
			$(this).removeClass("leaky");
			$(this).removeClass("benign");
			$(this).removeClass("deleterious");
		    }
		    else if(ri<-1){
			$(this).addClass("leaky");
			$(this).attr({title:"This is a leaky mutation"});
    			$(this).removeClass("probDel");
			$(this).removeClass("benign");
			$(this).removeClass("deleterious");
		    }
		    else {
			$(this).addClass("benign");
			$(this).attr({title:"This is a benign mutation. Polymorphism is probable."});
    			$(this).removeClass("probDel");
			$(this).removeClass("leaky");
			$(this).removeClass("deleterious");
		    }
		  });
		  $("#results_1").fadeIn(400);
		  $("#refTable").fadeIn(400);
		  $("#Legend_table").fadeIn(400);
		  });
		}
		},

	      error: function(xhr, textStatus, errorThrown) {
		alert('ajax loading error...');
	      }
	      });
	  }

	}
    });
    </script>
  </body>
</html>
