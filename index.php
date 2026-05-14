<?php
$privateKey = "";
$certificate = "";
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Ambil data form
    $country = strtoupper(trim($_POST['country'] ?? 'ID'));
    $state   = trim($_POST['state'] ?? '');
    $city    = trim($_POST['city'] ?? '');
    $org     = trim($_POST['org'] ?? '');
    $domain  = trim($_POST['domain'] ?? '');

    // Distinguished Name
    $dn = [
        "countryName"            => $country,
        "stateOrProvinceName"    => $state,
        "localityName"           => $city,
        "organizationName"       => $org,
        "commonName"             => $domain
    ];

    // Konfigurasi OpenSSL
    $config = [
        "digest_alg"       => "sha256",
        "private_key_bits" => 2048,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
        "x509_extensions"  => "v3_ca"
    ];

    // Generate Private Key
    $privkey = openssl_pkey_new($config);

    if (!$privkey) {

        $message = "❌ Gagal membuat private key";

    } else {

        // Generate CSR
        $csr = openssl_csr_new($dn, $privkey, $config);

        if (!$csr) {

            $message = "❌ Gagal membuat CSR";

        } else {

            // Generate Self Signed Certificate
            $x509 = openssl_csr_sign($csr, null, $privkey, 365, $config);

            if (!$x509) {

                $message = "❌ Gagal membuat sertifikat";

            } else {

                // Export Private Key
                openssl_pkey_export($privkey, $privateKey, null, $config);

                // Export Certificate
                openssl_x509_export($x509, $certificate);

                // Bersihkan Memory
                openssl_free_key($privkey);

                $message = "✅ SSL Certificate berhasil dibuat!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Modern SSL Generator</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>

        body{
            font-family:'Inter',sans-serif;
            background:linear-gradient(135deg,#0f172a,#1e293b,#111827);
            min-height:100vh;
            color:white;
        }

        .glass{
            background:rgba(15,23,42,.72);
            backdrop-filter:blur(12px);
            border:1px solid rgba(255,255,255,.08);
        }

        .card-shadow{
            box-shadow:0 10px 30px rgba(0,0,0,.25);
        }

        .mono{
            font-family:'JetBrains Mono',monospace;
        }

        .input-style{
            background:rgba(2,6,23,.65);
            border:1px solid rgba(255,255,255,.08);
            transition:.3s;
        }

        .input-style:focus{
            outline:none;
            border-color:#8b5cf6;
            box-shadow:0 0 0 4px rgba(139,92,246,.15);
        }

        textarea{
            resize:none;
        }

    </style>

</head>

<body class="px-5 py-8 lg:px-10">

<div class="max-w-7xl mx-auto">

    <!-- HEADER -->
    <div class="text-center mb-12">

        <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full glass text-purple-400 text-sm mb-6">
            SSL Certificate Generator
        </div>

        <h1 class="text-5xl md:text-6xl font-extrabold leading-tight">

            Modern
            <span class="bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent">
                SSL Generator
            </span>

        </h1>

        <p class="text-slate-400 mt-5 max-w-2xl mx-auto text-sm md:text-base">
            Generate RSA Private Key dan SSL Certificate menggunakan OpenSSL dengan tampilan clean dan modern.
        </p>

    </div>

    <!-- MAIN -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-7">

        <!-- FORM -->
        <div class="xl:col-span-4">

            <div class="glass card-shadow rounded-3xl p-7">

                <div class="flex items-center justify-between mb-8">

                    <div>

                        <h2 class="text-2xl font-bold">
                            CSR Identity
                        </h2>

                        <p class="text-slate-400 text-sm mt-1">
                            Input data sertifikat SSL
                        </p>

                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-2xl text-purple-400">
                        🔒
                    </div>

                </div>

                <form method="POST" class="space-y-5">

                    <div>

                        <label class="block mb-2 text-sm text-slate-300 font-semibold">
                            Country Code
                        </label>

                        <input
                            type="text"
                            name="country"
                            value="ID"
                            required
                            class="w-full rounded-2xl px-4 py-3 input-style"
                        >

                    </div>

                    <div>

                        <label class="block mb-2 text-sm text-slate-300 font-semibold">
                            State / Province
                        </label>

                        <input
                            type="text"
                            name="state"
                            placeholder="Kalimantan Barat"
                            required
                            class="w-full rounded-2xl px-4 py-3 input-style"
                        >

                    </div>

                    <div>

                        <label class="block mb-2 text-sm text-slate-300 font-semibold">
                            Locality / City
                        </label>

                        <input
                            type="text"
                            name="city"
                            placeholder="Pontianak"
                            required
                            class="w-full rounded-2xl px-4 py-3 input-style"
                        >

                    </div>

                    <div>

                        <label class="block mb-2 text-sm text-slate-300 font-semibold">
                            Organization Name
                        </label>

                        <input
                            type="text"
                            name="org"
                            placeholder="Universitas / Company"
                            required
                            class="w-full rounded-2xl px-4 py-3 input-style"
                        >

                    </div>

                    <div>

                        <label class="block mb-2 text-sm text-slate-300 font-semibold">
                            Common Name / Domain
                        </label>

                        <input
                            type="text"
                            name="domain"
                            placeholder="www.example.com"
                            required
                            class="w-full rounded-2xl px-4 py-3 input-style"
                        >

                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-2xl py-4 font-bold bg-gradient-to-r from-purple-500 to-blue-500 hover:opacity-90 transition duration-300 shadow-xl"
                    >
                        Generate SSL Certificate
                    </button>

                </form>

            </div>

        </div>

        <!-- OUTPUT -->
        <div class="xl:col-span-8">

            <div class="glass rounded-3xl overflow-hidden border border-slate-800 card-shadow">

                <!-- TOP BAR -->
                <div class="flex items-center justify-between px-6 py-5 border-b border-slate-800 bg-black/20">

                    <div class="flex items-center gap-3">

                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                        <div class="w-3 h-3 rounded-full bg-blue-500"></div>

                    </div>

                    <div class="mono text-xs text-slate-500">
                        SSL Certificate Output
                    </div>

                </div>

                <!-- CONTENT -->
                <div class="p-6 lg:p-8 min-h-[700px]">

                    <?php if($message): ?>

                        <div class="mb-6 rounded-2xl border border-purple-500/30 bg-purple-500/10 p-4 text-purple-400">
                            <?= htmlspecialchars($message) ?>
                        </div>

                    <?php endif; ?>

                    <?php if($privateKey && $certificate): ?>

                        <!-- PRIVATE KEY -->
                        <div class="mb-10">

                            <div class="flex items-center justify-between mb-4">

                                <h3 class="text-2xl font-bold text-white">
                                    RSA Private Key
                                </h3>

                                <span class="text-xs px-4 py-2 rounded-full border border-purple-500/20 bg-purple-500/10 text-purple-400">
                                    PRIVATE KEY
                                </span>

                            </div>

                            <textarea
                                rows="14"
                                readonly
                                class="w-full rounded-3xl bg-black/40 border border-slate-800 text-purple-300 mono p-5 text-sm"
                            ><?= htmlspecialchars($privateKey) ?></textarea>

                        </div>

                        <!-- CERTIFICATE -->
                        <div>

                            <div class="flex items-center justify-between mb-4">

                                <h3 class="text-2xl font-bold text-white">
                                    SSL Certificate
                                </h3>

                                <span class="text-xs px-4 py-2 rounded-full border border-blue-500/20 bg-blue-500/10 text-blue-400">
                                    X.509 CRT
                                </span>

                            </div>

                            <textarea
                                rows="14"
                                readonly
                                class="w-full rounded-3xl bg-black/40 border border-slate-800 text-blue-300 mono p-5 text-sm"
                            ><?= htmlspecialchars($certificate) ?></textarea>

                        </div>

                    <?php else: ?>

                        <!-- EMPTY STATE -->
                        <div class="flex flex-col items-center justify-center min-h-[620px] text-center px-6">

                            <div class="w-28 h-28 rounded-full bg-purple-500/10 border border-purple-500/20 flex items-center justify-center mb-8 text-5xl">
                                🔐
                            </div>

                            <h3 class="text-4xl font-bold mb-4">
                                Ready to Generate
                            </h3>

                            <p class="text-slate-400 max-w-lg leading-relaxed">
                                Isi seluruh identitas sertifikat pada form sebelah kiri lalu tekan tombol Generate untuk membuat RSA Private Key dan SSL Certificate berbasis OpenSSL.
                            </p>

                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

    <!-- FOOTER -->
    <div class="mt-10 text-center">

        <div class="inline-flex items-center gap-4 glass rounded-2xl px-6 py-4 text-sm text-slate-400">

            <span>
                Tugas Praktikum Kriptografi SSL/TLS
            </span>

            <span>
                •
            </span>

            <span>
                Muhammad Naufal Welendra (231220066)
            </span>

        </div>

    </div>

</div>

</body>
</html>