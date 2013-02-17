//Randomly shuffles an array using the Fisher-Yates algorithm
function shuffle ( myArray ) {
  var i = myArray.length;
  if ( i == 0 ) return false;
  while ( --i ) {
     var j = Math.floor( Math.random() * ( i + 1 ) );
     var tempi = myArray[i];
     myArray[i] = myArray[j];
     myArray[j] = tempi;
   }
}