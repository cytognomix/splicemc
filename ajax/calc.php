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

//column order in known splice site files
$col_refNuc	= 0;
$col_altNuc	= 1;
$col_deltaRi	= 2;
$col_pos	= 3;

//read variables posted from calculator webpage
$spliceSitePos 	= $_POST['spliceSitePos'];
$refNuc		= strtoupper($_POST['refNuc']);
$altNuc		= strtoupper($_POST['altNuc']);
$spliceSiteType = strtoupper($_POST['spliceSiteType']);

//load known splice site array with data from file appropriate to the selected splice site type
$knownSpliceSiteList = array();
$ribl = array();
switch ($spliceSiteType) {
	case 'DONOR':
		$knownSpliceSiteList = file('./Donors_14_10_12.txt', FILE_IGNORE_NEW_LINES);
		$ribl = loadRibl('dontot_111772');
	break;
	case 'ACCEPTOR':
		$knownSpliceSiteList = file('./Acceptors_14_10_12.txt', FILE_IGNORE_NEW_LINES);
		$ribl = loadRibl('acctot_108079');
	break;

	case 'DONOR_OLD':
		$knownSpliceSiteList = file('./Donors_14_10_12.txt', FILE_IGNORE_NEW_LINES);
		$ribl = loadRibl('dontot_old');
	break;
	case 'ACCEPTOR_OLD':
		$knownSpliceSiteList = file('./Acceptors_14_10_12.txt', FILE_IGNORE_NEW_LINES);
		$ribl = loadRibl('acctot_old');
	break;

	default:
		exit();
	break;
}

$deltaRiFromRibl = abs( $ribl[$spliceSitePos][$refNuc] - $ribl[$spliceSitePos][$altNuc] );
if($ribl[$spliceSitePos][$refNuc] > $ribl[$spliceSitePos][$altNuc]) {
	$deltaRiFromRibl *= -1;
}

$roundedDeltaRiFromRibl = round($deltaRiFromRibl, 2);

//fill array with the specified splice site position only
$sitesAtPos = getListForPosition($knownSpliceSiteList, $spliceSitePos, $col_pos);

//record the number of times the variant appears and its delta Ri
$matchCount = 0;
$deltaRi = 0;
$deltaRiSum = 0;
$meanDeltaRi = 0;
foreach($sitesAtPos as $tempArr) {
	if( ($tempArr[$col_refNuc] == $refNuc) && ($tempArr[$col_altNuc] == $altNuc) ) {
		$deltaRi = $tempArr[$col_deltaRi];
		$deltaRiSum += $tempArr[$col_deltaRi];
		$matchCount++;
	}
}

//if no matches found in literature review. Set literature review Ri to NA
if($matchCount == 0) $deltaRi = 'NA'; //if matches were found in literature review

//send response to webpage
$returnArr = array('RiExperimental' => $deltaRi, 'RiFromRibl' => $roundedDeltaRiFromRibl, 'Count' => $matchCount);	
echo json_encode($returnArr);

//returns known splice site data from specific position
function getListForPosition($spliceSites, $pos, $col_pos) {
	$sitesAtPos = array();
	foreach ($spliceSites as $line) {
		$lineArr = explode("\t", $line);
		if($pos == $lineArr[$col_pos]) {
			$sitesAtPos[] = $lineArr;	
		}
	}
	return $sitesAtPos;
}

//loads ribl by name
function loadRibl($name) {
	switch($name) {
		case 'dontot_111772':
		return array(
			-3 => array(
				'A' => 0.291803,
				'C' => 0.392208,
				'G' => -0.581031,
				'T' => -1.208800
			),
			-2 => array(
				'A' => 1.232712,
				'C' => -1.395797,
				'G' => -1.291090,
				'T' => -1.003109
			),
			-1 => array(
                'A' => -1.457257,
                'C' => -3.358357,
                'G' => 1.552396,
                'T' => -2.041253
        	),
			0 => array(
                'A' => -16.770225,
                'C' => 16.770225,
                'G' => 1.863020,
                'T' => -16.770225
        	),
			1 => array(
                'A' => -16.770225,
                'C' => -5.180961,
                'G' => -16.770225,
                'T' => 1.852046
        	),
			2 => array(
                'A' => 1.123186,
                'C' => -3.390987,
                'G' => 0.341378,
                'T' => -3.364147
        	),
			3 => array(
                'A' => 1.346557,
                'C' => -1.912296,
                'G' => -1.261296,
                'T' => -1.279987
        	),
			4 => array(
                'A' => -1.665643,
                'C' => -2.356433,
                'G' => 1.512419,
                'T' => -1.866034
        	),
			5 => array(
                'A' => -0.629965,
                'C' => -0.907091,
                'G' => -0.515264,
                'T' => 0.814401
        	),
			6 => array(
                'A' => 0.103873,
                'C' => -0.508035,
                'G' => 0.103261,
                'T' => -0.348041
        	),
		);
		break;
		
		case 'acctot_108079':
		return array(
			-25 => array(
				'A' => -0.115766,
				'C' => -0.110617,
				'G' => -0.736962,
				'T' => 0.384017
			),
			-24 => array(
				'A' => -0.114464,
				'C' => -0.122569,
				'G' => -0.773158,
				'T' => 0.407782
			),
			-23 => array(
				'A' => -0.148107,
				'C' => -0.089349,
				'G' => -0.819277,
				'T' => 0.427552
			),
			-22 => array(
				'A' => -0.192198,
				'C' => -0.067602,
				'G' => -0.815480,
				'T' => 0.439721
			),
			-21 => array(
				'A' => -0.230723,
				'C' => -0.064665,
				'G' => -0.855721,
				'T' => 0.478290
			),
			-20 => array(
				'A' => -0.332108,
				'C' => -0.041787,
				'G' => -0.854905,
				'T' => 0.521381
			),
			-19 => array(
				'A' => -0.444293,
				'C' => -0.044627,
				'G' => -0.860899,
				'T' => 0.583963
			),
			-18 => array(
				'A' => -0.604128,
				'C' => 0.004007,
				'G' => -0.882632,
				'T' => 0.633225
			),
			-17 => array(
				'A' => -0.771275,
				'C' => 0.033046,
				'G' => -0.942238,
				'T' => 0.700050
			),
			-16 => array(
				'A' => -0.911184,
				'C' => 0.050764,
				'G' => -0.978411,
				'T' => 0.747564
			),
			-15 => array(
				'A' => -1.049649,
				'C' => 0.062185,
				'G' => -1.042200,
				'T' => 0.800196
			),
			-14 => array(
				'A' => -1.187796,
				'C' => 0.110561,
				'G' => -1.104301,
				'T' => 0.823999
			),
			-13 => array(
				'A' => -1.310445,
				'C' => 0.101435,
				'G' => -1.178806,
				'T' => 0.876803
			),
			-12 => array(
				'A' => -1.462199,
				'C' => 0.086552,
				'G' => -1.281895,
				'T' => 0.939627
			),
			-11 => array(
				'A' => -1.613911,
				'C' => 0.094130,
				'G' => -1.414399,
				'T' => 0.988962
			),
			-10 => array(
				'A' => -1.744331,
				'C' => -0.018150,
				'G' => -1.463304,
				'T' => 1.074111
			),
			-9 => array(
				'A' => -1.706550,
				'C' => 0.104934,
				'G' => -1.361035,
				'T' => 0.987623
			),
			-8 => array(
				'A' => -1.506218,
				'C' => 0.163064,
				'G' => -1.291186,
				'T' => 0.905925
			),
			-7 => array(
				'A' => -1.364515,
				'C' => 0.305502,
				'G' => -1.414934,
				'T' => 0.811319
			),
			-6 => array(
				'A' => -1.285800,
				'C' => 0.350727,
				'G' => -1.657984,
				'T' => 0.808861
			),
			-5 => array(
				'A' => -1.701489,
				'C' => 0.398383,
				'G' => -2.219185,
				'T' => 0.936436
			),
			-4 => array(
				'A' => -1.659250,
				'C' => 0.181386,
				'G' => -2.190767,
				'T' => 1.059663
			),
			-3 => array(
				'A' => -0.174106,
				'C' => 0.072944,
				'G' => -0.410065,
				'T' => 0.088533
			),
			-2 => array(
				'A' => -2.294624,
				'C' => 1.279460,
				'G' => -7.500394,
				'T' => 0.159927
			),
			-1 => array(
				'A' => 1.901492,
				'C' => -16.721753,
				'G' => -12.813277,
				'T' => -5.802049
			),
			0 => array(
				'A' => -8.980387,
				'C' => -9.768883,
				'G' => 1.900553,
				'T' => -5.847492
			),
			1 => array(
				'A' => -0.052609,
				'C' => -0.945805,
				'G' => 0.892356,
				'T' => -1.270487
			),
			2 => array(
				'A' => -0.111754,
				'C' => -0.502948,
				'G' => -0.461854,
				'T' => 0.482205
			),
		);
		break;
		
		case 'dontot_old':
		return array(
			-3 => array(
				'A' => 0.421835,
				'C' => 0.580283,
				'G' => -0.580560,
				'T' => -1.019764
			),
			-2 => array(
				'A' => 1.250563,
				'C' => -0.775260,
				'G' => -1.039392,
				'T' => -0.871665
			),
			-1 => array(
                'A' => -1.413300,
                'C' => -2.404789,
                'G' => 1.641148,
                'T' => -1.674628
        	),
			0 => array(
                'A' => -10.814582,
                'C' => -7.814179,
                'G' => 1.990758,
                'T' => -5.814179
        	),
			1 => array(
                'A' => -5.814179,
                'C' => -5.492251,
                'G' => -6.229217,
                'T' => 1.979424
        	),
			2 => array(
                'A' => 1.120824,
                'C' => -3.677671,
                'G' => 0.720523,
                'T' => -3.380689
        	),
			3 => array(
                'A' => 1.508196,
                'C' => -1.559026,
                'G' => -1.058761,
                'T' => -1.587785
        	),
			4 => array(
                'A' => -1.805341,
                'C' => -2.235485,
                'G' => 1.714295,
                'T' => -2.205428
        	),
			5 => array(
                'A' => -0.684323,
                'C' => -0.513211,
                'G' => -0.318195,
                'T' => 0.904198
        	),
			6 => array(
                'A' => 0.045799,
                'C' => -0.168191,
                'G' => 0.443883,
                'T' => -0.486215
        	),
		);
		break;
		
		case 'acctot_old':
		return array(
			-25 => array(
				'A' => -0.068943,
				'C' => 0.274303,
				'G' => -0.639967,
				'T' => 0.252051
			),
			-24 => array(
				'A' => -0.213048,
				'C' => 0.361646,
				'G' => -0.597712,
				'T' => 0.247314
			),
			-23 => array(
				'A' => -0.263142,
				'C' => 0.258810,
				'G' => -0.574540,
				'T' => 0.372021
			),
			-22 => array(
				'A' => -0.179293,
				'C' => 0.323793,
				'G' => -0.617735,
				'T' => 0.273793
			),
			-21 => array(
				'A' => -0.095406,
				'C' => 0.276987,
				'G' => -0.766956,
				'T' => 0.333571
			),
			-20 => array(
				'A' => -0.418121,
				'C' => 0.314183,
				'G' => -0.706981,
				'T' => 0.476306
			),
			-19 => array(
				'A' => -0.401412,
				'C' => 0.198501,
				'G' => -0.587631,
				'T' => 0.511477
			),
			-18 => array(
				'A' => -0.672032,
				'C' => 0.381161,
				'G' => -0.464227,
				'T' => 0.422981
			),
			-17 => array(
				'A' => -0.772593,
				'C' => 0.399722,
				'G' => -0.907945,
				'T' => 0.639750
			),
			-16 => array(
				'A' => -0.839566,
				'C' => 0.447561,
				'G' => -0.795398,
				'T' => 0.581998
			),
			-15 => array(
				'A' => -0.930477,
				'C' => 0.404079,
				'G' => -0.710351,
				'T' => 0.619720
			),
			-14 => array(
				'A' => -1.195571,
				'C' => 0.395466,
				'G' => -0.906895,
				'T' => 0.774444
			),
			-13 => array(
				'A' => -1.450175,
				'C' => 0.397822,
				'G' => -0.904939,
				'T' => 0.830561
			),
			-12 => array(
				'A' => -1.602104,
				'C' => 0.464338,
				'G' => -1.089898,
				'T' => 0.861621
			),
			-11 => array(
				'A' => -1.638125,
				'C' => 0.408797,
				'G' => -1.309060,
				'T' => 0.958712
			),
			-10 => array(
				'A' => -1.787076,
				'C' => 0.347444,
				'G' => -1.349267,
				'T' => 1.029617
			),
			-9 => array(
				'A' => -1.647377,
				'C' => 0.379896,
				'G' => -1.229589,
				'T' => 0.963056
			),
			-8 => array(
				'A' => -1.411136,
				'C' => 0.490814,
				'G' => -1.111576,
				'T' => 0.809273
			),
			-7 => array(
				'A' => -1.284109,
				'C' => 0.647178,
				'G' => -1.284109,
				'T' => 0.686231
			),
			-6 => array(
				'A' => -1.367963,
				'C' => 0.616654,
				'G' => -1.430505,
				'T' => 0.769540
			),
			-5 => array(
				'A' => -1.800212,
				'C' => 0.689815,
				'G' => -1.961367,
				'T' => 0.879325
			),
			-4 => array(
				'A' => -1.772453,
				'C' => 0.443433,
				'G' => -2.074638,
				'T' => 1.074912
			),
			-3 => array(
				'A' => -0.140749,
				'C' => 0.200095,
				'G' => -0.007914,
				'T' => -0.079807
			),
			-2 => array(
				'A' => -2.697543,
				'C' => 1.527539,
				'G' => -4.441704,
				'T' => -0.130637
			),
			-1 => array(
				'A' => 1.977077,
				'C' => -5.446669,
				'G' => -6.183634,
				'T' => -5.446669
			),
			0 => array(
				'A' => -5.599499,
				'C' => -5.309993,
				'G' => 1.978769,
				'T' => -6.769424
			),
			1 => array(
				'A' => 0.046109,
				'C' => -0.912713,
				'G' => 1.0020676,
				'T' => -1.217568
			),
			2 => array(
				'A' => -0.028922,
				'C' => -0.496845,
				'G' => -0.073634,
				'T' => 0.440939
			),
		);
		break;
	}
}

?>
