// Methods for existing objects


// Moves an element in an array (faster than with splice)
Array.prototype.move = function (from, to) {
	// local variables
	var i, tmp;
	// cast input parameters to integers
	from = parseInt(from, 10);
	to = parseInt(to, 10);
	// if positions are different and inside array
	if (from !== to &&
		0 <= from && from <= this.length &&
		0 <= to && to <= this.length) {
		// save element from position 1
		tmp = this[from];
		// move element down and shift other elements up
		if (from < to) {
			for (i = from; i < to; i++) {
				this[i] = this[i + 1];
			}
		}
		// move element up and shift other elements down
		else {
			for (i = from; i > to; i--) {
				this[i] = this[i - 1];
			}
		}
		this[to] = tmp;
	}
}

// Randomly shuffles an array using the Fisher-Yates algorithm
Array.prototype.shuffle = function () {
	var i = this.length;
	if ( i == 0 ) return false;
	while ( --i ) {
		var j = Math.floor( Math.random() * ( i + 1 ) );
		var tempi = this[i];
		this[i] = this[j];
		this[j] = tempi;
   }
}

// Correctly sorts numerical values in an array (ie 2 before 10)
Array.prototype.sortNum = function () {
	this.sort(function(a,b){
		return a-b
	});
}

// find a string in an array (from: http://www.hunlock.com/blogs/Mastering_Javascript_Arrays#quickIDX40)
// returns an array with the indexes
// accepts reg exps
Array.prototype.find = function(searchStr) {
	var returnArray = [];
	if (typeof(searchStr) == 'function') {
		for (i=0; i<this.length; i++) {
			if (searchStr.test(this[i])) {
				returnArray.push(i);
			}
		}
	} else {
		for (i=0; i<this.length; i++) {
			if (this[i]===searchStr) {	
				returnArray.push(i);
			}
		}
	}
	if (returnArray.length==0) {
		var returnArray = false;
	}
	return returnArray;
}

// Array Remove - By John Resig (MIT Licensed)
// Negative indeces mean from the end, so .remove(-3,-1) removes the last three items
Array.prototype.remove = function(from, to) {
	var rest = this.slice((to || from) + 1 || this.length);
	this.length = from < 0 ? this.length + from : from;
	return this.push.apply(this, rest);
};
