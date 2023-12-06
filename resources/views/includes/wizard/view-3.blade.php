@php($loopTripMode = $tripMode !== 'defer' ? 'lazy' : $tripMode)

@include('includes.persons', [ 'personType' => "author", 'personNumber' => $authorNumber, 'wirePerson' => "formData.author."])

@include('includes.persons', [ 'personType' => "contributor", 'personNumber' => $contributorNumber, 'wirePerson' => "formData.contributor."])

<hr class="style1"/>

@include('includes.persons', [ 'personType' => "maintainer", 'personNumber' => $maintainerNumber, 'wirePerson' => "formData.maintainer."])

<hr class="style1"/>

@include('includes.funders')

<hr class="final">

