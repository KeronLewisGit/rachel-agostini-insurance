<x-layout title="Privacy" description="How Rachel Agostini handles the details you share through this website." :noindex="false">
    <x-page-hero eyebrow="Privacy" title="How your details are handled." :crumbs="['Privacy' => null]" />
    <section class="section">
        <div class="wrap max-w-3xl prose-site">
            <p>This website is operated by Rachel Agostini, a sales representative of Guardian Life of the Caribbean Limited. It is not operated by Guardian Group.</p>
            <p><strong>What is collected.</strong> When you send a quote request, calculator estimate, call-back request or message, the details you enter are stored so Rachel can respond. The site also records which page you arrived on and, if present, campaign tags in the link you followed, so Rachel knows which of her posts people found useful.</p>
            <p><strong>How it is used.</strong> Only to respond to your request and, if you become a client, to arrange and service your policy. Your details are not sold or shared with third parties for marketing. Policy applications are submitted to the relevant Guardian Group company under its own privacy policy.</p>
            <p><strong>Calculators.</strong> Calculator inputs stay in your browser unless you choose to send the estimate to Rachel. Results are estimates for discussion, not quotations or advice.</p>
            <p><strong>Your choices.</strong> Ask Rachel at any time to see, correct or delete the details held about you by emailing <span class="break-all">{{ config('site.email') }}</span>.</p>
        </div>
    </section>
</x-layout>
