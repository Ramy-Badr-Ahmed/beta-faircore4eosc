@extends('layouts.single-column-page')

<x-beta.navigation-bar :mtime="(new DateTime('Europe/Berlin'))->setTimeStamp(File::lastModified(base_path('resources/views/pages/general/imprint.blade.php')))->format('d/M/y @H:i')" />

@section('headline', 'Imprint')

@section('main')

    <p>
        <b>This website is published by</b>
        <br>
        <br>
        <a href="https://maps.app.goo.gl/pcifhswiFZXgzmHQA" target='_blank' rel='noopener noreferrer'>Schloss Dagstuhl<br>
            Leibniz-Zentrum f&uuml;r Informatik GmbH<br>
            Oktavie-Allee<br>
            66687 Wadern<br>
            Deutschland<br>
        </a>
        <br>
        <br>
        Phone <a href="tel:+4968719050">+49 - 6871 - 905 0</a><br>
        Fax  <a href="tel:+496871905133">+49 - 6871 - 905 133</a><br>
        <br>
        E-Mail: <a href="mailto:service@dagstuhl.de">service(at)dagstuhl.de</a><br>
        Internet: <a href="https://dagstuhl.de/" class="uri" target='_blank' rel='noopener noreferrer'>www.dagstuhl.de</a><br>
        <br>
        Scientific Director: Prof. Dr. Raimund Seidel<br>
        Administrative Director: Heike Mei&szlig;ner<br>
        Court: <a href="https://www.saarland.de/agsb/DE/home/home_node.html" target='_blank' rel='noopener noreferrer'>Amtsgericht Saarbr&uuml;cken</a><br>
        Court Registration: HRB 63800<br>
        VAT-ID: DE 137972446<br><br>
    </p>
    <p>
        <b>Disclaimer of Liability</b>
        <br><br>
        By using our web pages you acknowledge the following disclaimer of liability:
        Apart from offering content of our own and hyperlinks to third-party websites, our service also makes publications available for which the authors of the publications are solely responsible.<br>
        The website content is provided "as-is", i.e. the website owners assume no liability for the up-to-dateness, correctness, completeness or quality of the information provided on the website. No liability whatsoever shall be assumed for claims lodged against the owners following from material or immaterial damage or loss as the result of the use of or the inability to use the information offered or the use of erroneous or incomplete information, unless premeditation or gross negligence on the part of the website owners can be demonstrated.
        All website offerings are non-binding and at no obligation to the owners. The owners expressly reserve the right to modify, supplement or delete parts of pages or the entire website offerings without notice, or temporarily or permanently discontinue publication of content (with the exception of the publications on our online publication server).<br>
        Only publications and links are included whose content in the fair judgment of the website owners does not violate applicable German law at the time of inclusion. However, despite careful examination and taking every precaution it cannot be precluded that individual web pages or documents may contain content which is subject to criminal prosecution or directly or indirectly point to pages containing criminal content.
        Consequently, the institution operating the website and its personnel assume no liability whatsoever for the content of the publications made available by it or on external web pages. Nor is any liability assumed for any false statements, misrepresentations or legal offenses in the publications made available on the website or on external web pages quoted. The opinions and/or claims expressed in the publications provided or on linked web pages are the sole responsibility of the authors expressing them.
        <br><br>
    </p>
    <p>
        <b>Copyright</b>
        <br><br>
        Schloss Dagstuhl GmbH retains full copyright over texts, graphics, pictures, and design on this web site.
        <br>
    </p>

@endsection
