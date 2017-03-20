# KrumhanslSchmuckler-php
A PHP implementation for the Krumhansl-Schmuckler musical key finding algorithm

<b>How to use</b>
<ul>
<li>
Import the module
</li>
<li>
Initialise the KeyFinder class
</li>
<li>
Add chords to the object using the addChord(string $chord) function (note: flat chords currently not implemented)
</li>
<li>
Find the key of the music using the getKey() function (return's a string)
</li>
</ul>

<b>Current Limitations:</b>
<ul>
<li>
Minor key finding unspoorted, should return the equivalent major key.
</li>
<li>
Doesn't currently support the flat sign 'b' as an input.
</li>
<u/l>
