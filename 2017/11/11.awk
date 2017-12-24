BEGIN { RS = "," }

function abs(x) { return (x > 0) ? x : -x }
function max(x, y) { return (x > y) ? x : y }
function dist(x, y, z) { return (abs(x) + abs(y) + abs(z)) / 2 }

{ furthest = max(dist(x, y, z), furthest) }
/ne/ { x++; z--; next }
/sw/ { x--; z++; next }
/se/ { x++; y--; next }
/nw/ { x--; y++; next }
/s/  { y--; z++; next }
/n/  { y++; z--; }

END {
    print "distance:", dist(x, y, z)
    print "furthest:", furthest
}
