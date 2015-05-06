
var nodes = document.getElementsByTagName( 'input' );

for( var i = 0; i < nodes.length; i++ ) {
	var field = nodes[ i ];
	checkValid( field );
	field.onkeyup = function(){ checkValid(this); };

}

function checkValid( field ){
	if( typeof field.validity !== 'undefined' )  {
		var lab = null;
		if( field.parentNode.tagName === 'LABEL')
			lab = field.parentNode;
		else
		 	lab = field.parentNode.getElementsByTagName('label')[0];

		if( lab !== null && typeof lab !== 'undefined' )
			if( field.validity.valid === false )	
				lab.classList.add( 'invalid' );
			else
				lab.classList.remove( 'invalid' );
	}
}