function setPointeron(theRow)
{
    if (typeof(theRow.style) == 'undefined') {
        return false;
    }
    if (typeof(document.getElementsByTagName) != 'undefined') {
        var theCells = theRow.getElementsByTagName('td');
    }
    else if (typeof(theRow.cells) != 'undefined') {
        var theCells = theRow.cells;
    }
    else {
        return false;
    }

    var rowCellsCnt  = theCells.length;
    for (var c = 0; c < rowCellsCnt; c++) {
        theCells[c].style.backgroundColor = "#FF9900";
    }

    return true;
}

function setPointeroff(theRow)
{
    if (typeof(theRow.style) == 'undefined') {
        return false;
    }
    if (typeof(document.getElementsByTagName) != 'undefined') {
        var theCells = theRow.getElementsByTagName('td');
    }
    else if (typeof(theRow.cells) != 'undefined') {
        var theCells = theRow.cells;
    }
    else {
        return false;
    }

    var rowCellsCnt  = theCells.length;
    for (var c = 0; c < rowCellsCnt; c++) {
        theCells[c].style.backgroundColor = "#ffffff";
    }

    return true;
}

function loadwindow(fname)
	{
	delwindow = window.open(fname,'message', 'menubar=no,resizeable=no,scrollbars=no,titlebar=no,width=250,height=140');
	delwindow.moveTo((screen.availWidth-300)/2,(screen.availHeight-100)/2);
	}
	
function dateiload(headline)
	{
	parent.headline.location.href = headline;
	}
