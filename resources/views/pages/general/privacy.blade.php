@extends('layouts.single-column-page')

<x-beta.navigation-bar :mtime="(new DateTime('Europe/Berlin'))->setTimeStamp(File::lastModified(base_path('resources/views/pages/general/privacy.blade.php')))->format('d/M/y @H:i')" />

@section('headline', 'Data Privacy Policy')

@section('subtitle')

    <h4>Section "Dagstuhl Publishing"</h4>
    <br>

@endsection

@section('main')

    <p>As of May 25th, 2018, we are updating our data privacy policy in accordance with the EU General Data Protection Regulation (GDPR) and German national regulations. On this page, you can find an abridged summary of our policy. For the complete policy (in German only), see:</p>
    <p><a href="https://www.dagstuhl.de/meta-menue/datenschutz/datenschutz-publishing/" target='_blank' rel='noopener noreferrer'>Datenschutzerklärung gemäß DSGVO Art. 12 im Bereich “Dagstuhl Publishing”</a></p>

    <h3 id="general-principles">General principles</h3>

    <ul>
        <li>We process personal data only to the extent necessary for the scientific reviewing, publication, documentation, and archival within the different Dagstuhl series and periodicals.</li>
        <li>With the exception of the metadata and files of published documents and the documents to be reviewed (currently only in the two journals LITES and Dagstuhl Manifestos), we do not share any of your personal data with third parties.</li>
        <li>We do not track your user behavior or process any of your data for purposes of marketing or advertising.</li>
        <li>There is no automated individual decision-making such as profiling or scoring.</li>
    </ul>

    <h3 id="our-web-services-and-log-files">Our web services and log files</h3>

    <p>The Dagstuhl Publishing web services (<a href="https://faircore4eosc.dagstuhl.de/" class="uri" target='_blank' rel='noopener noreferrer'>https://faircore4eosc.dagstuhl.de/</a>, <a href="https://drops.dagstuhl.de/" class="uri" target='_blank' rel='noopener noreferrer'>https://drops.dagstuhl.de/</a>, <a href="https://ojs.dagstuhl.de" class="uri" target='_blank' rel='noopener noreferrer'>https://ojs.dagstuhl.de</a>, <a href="https://www.dagstuhl.de/publikationen/" class="uri" target='_blank' rel='noopener noreferrer'>https://www.dagstuhl.de/publikationen/</a>, <a href="https://submission.dagstuhl.de" class="uri" target='_blank' rel='noopener noreferrer'>https://submission.dagstuhl.de</a>) make use of log files and HTTP cookies.</p>
    <p>Log files of HTTP requests are stored by the web services to guarantee the operation of our services. Log files are deleted regularly, but at the latest after 12 months, and are protected against unauthorized access.</p>
    <p>Cookies are only used in our Submission System and the Journal Management System (currently only used for our journal LITES) to manage user sessions. Cookies aren’t required for simply visiting the site and reading content.</p>

    <h3 id="the-dagstuhl-publishing-services">The Dagstuhl Publishing Services</h3>

    <p>Dagstuhl Publishing publishes conference proceedings, a journal, and a data journal and consolidates all seminar-related publishing efforts, all in an open access manner. The series can be classified into two groups: (1) service-focused series (OASIcs, LIPIcs, LITES, and DARTS) and (2) seminar-focused series (Dagstuhl Reports, Dagstuhl Manifestos, and Dagstuhl Follow-Ups).</p>
    <p>In the service-focused series, peer-reviewed scientific documents and data (in case of DARTS) from all areas of computer science are published. All publications (and their metadata) also contain person-related data provided by authors and editors about themselves for the purpose of identification, such as names, persistent IDs like ORCIDs, affiliations, email addresses, or hyperlinks to academic websites.</p>
    <p>The seminar-focused series are strongly intertwined with Dagstuhl’s seminar and workshop program and provide a platform to meet the different requirements from this program regarding documentation and dissemination. These publications also contain person-related data such as names, affiliations, and email addresses of participants.</p>
    <p>All bibliographic metadata and documents are published open access, are republished indefinitely and globally accessible on our servers via web pages (<a href="https://drops.dagstuhl.de/" class="uri" target='_blank' rel='noopener noreferrer'>https://drops.dagstuhl.de/</a>, <a href="https://ojs.dagstuhl.de" class="uri" target='_blank' rel='noopener noreferrer'>https://ojs.dagstuhl.de</a>), data interfaces (“APIs”), and as download. The metadata is available in various machine-readable data formats. You can view all bibliographic metadata and documents stored about you at any time and in full via our Publication Server (DROPS) and the APIs.</p>
    <p>Since the document and metadata are processed to fulfill our duties as scientific publisher and only to the extent necessary for the scientific reviewing, publication, documentation, and archival within the different Dagstuhl series and periodicals, there is therefore only a possibility of objection if this arises from your particular situation, and if your fundamental rights and freedoms outweigh the legitimate information interests of the international research community to access the public metadata and documents. If you feel you are in such a situation, please contact our data protection officer via the e-mail address <a href="mailto:publishing-privacy@dagstuhl.de" class="uri" target='_blank' rel='noopener noreferrer'>publishing-privacy@dagstuhl.de</a>. (Please do not use this address for non-privacy related requests. For usual publishing inquiries please contact the publishing team via <a href="mailto:publishing@dagstuhl.de" class="uri" target='_blank' rel='noopener noreferrer'>publishing@dagstuhl.de</a>.)</p>
    <p>Nevertheless, you are of course free to contact us at any time for the purpose of withdrawing your scientific publications. With the successful withdrawal or retraction of your publication, we will also remove the publication’s person-related data.</p>

@endsection
