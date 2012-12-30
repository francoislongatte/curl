<?php
function relative_time($iTime)
	{
	
		$iTimeDifference = time() - $iTime ;
		
		if($iTimeDifference<0){
		return; 
		}
		
		$iSeconds = $iTimeDifference ;
		$iMinutes = round( $iTimeDifference/60 );
		$iHours = round( $iTimeDifference/3600 );
		$iDays = round( $iTimeDifference/86400 );
		$iWeeks = round( $iTimeDifference/604800 );
		$iMonths = round( $iTimeDifference/2419200 );
		$iYears = round( $iTimeDifference/29030400 );
		
		if( $iSeconds<60 )
		{	
			return "Il y a moins d’une minute";
		}
		elseif( $iMinutes<60 )
		{
			return 'Il y a ' . $iMinutes . ' minute' . ( $iMinutes>1 ? 's' :  '' );
		}
		elseif( $iHours<24 )
		{
			return 'Il y a ' . $iHours . ' heure' . ( $iHours>1 ? 's' :  '' );
		}
		elseif( $iDays<7 )
		{
			return 'Il y a ' . $iDays . ' jour' . ( $iDays>1 ? 's' :  '' );
		}
		elseif( $iWeeks <4 )
		{
			return 'Il y a ' . $iWeeks . ' semaine' . ( $iWeeks>1 ? 's' : '' );
		}
		elseif( $iMonths<12 )
		{
			return 'Il y a ' . $iMonths . ' mois';
		}
		else
		{
			return 'Il y a ' . $iYears . ' an' . ( $iYears>1 ? 's' :  '' );
		}
	}
