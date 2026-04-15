<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank BTN - Digital Loan Service v3.2</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        btn: { blue: '#004a99', dark: '#002d5e', yellow: '#f8be14', bg: '#f6f8fc' }
                    }
                }
            }
        }
    </script>

    <style>
        html, body { font-size: 16px; background-color: #f6f8fc; width: 100%; overflow-x: hidden; }
        .gmail-row:hover { box-shadow: inset 1px 0 0 #dadce0, inset -1px 0 0 #dadce0, 0 1px 2px 0 rgba(60,64,67,.3), 0 1px 3px 1px rgba(60,64,67,.15); }
        
        #sidebar { transform: translateX(-100%); transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        #sidebar.open { transform: translateX(0); }
        
        .tracking-dot { width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 0 2px #e2e8f0; }
        .dot-active { background-color: #004a99; box-shadow: 0 0 0 2px #004a99; }
        
        .animate-in { animation: fadeIn 0.4s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        .nav-btn.active { color: #004a99; border-bottom: 4px solid #004a99; font-weight: 900; }
        .custom-scroll::-webkit-scrollbar { width: 5px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body class="text-slate-700 font-sans min-h-screen">

    <!-- 1. GLOBAL SIDEBAR -->
    <div id="sidebar-overlay" onclick="app.toggleSidebar()" class="fixed inset-0 z-[60] bg-black/40 hidden opacity-0 transition-opacity duration-300"></div>
    <aside id="sidebar" class="fixed top-0 left-0 bottom-0 w-80 bg-white z-[70] shadow-2xl flex flex-col p-8 border-r">
        <div class="flex items-center justify-between mb-12">
            <div class="flex items-center gap-4 text-slate-800">
                <div class="w-12 h-12 bg-btn-blue rounded-xl flex items-center justify-center text-white font-black text-2xl shadow-lg font-black">B</div>
                <span class="font-black text-btn-blue text-lg tracking-tighter uppercase font-black">BTN Digital LS</span>
            </div>
            <button onclick="app.toggleSidebar()" class="text-slate-300 hover:text-red-500 transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <nav id="sidebar-nav" class="flex-grow space-y-3">
            <div id="nav-general" class="space-y-3">
                <button onclick="app.setSection('inbox')" class="w-full flex items-center gap-4 p-4 rounded-2xl bg-blue-50 text-btn-blue font-black text-xs uppercase shadow-sm transition-all font-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> Kotak Masuk
                </button>
                <button onclick="app.setSection('tracking')" id="nav-tracking" class="w-full flex items-center gap-4 p-4 rounded-2xl text-slate-400 font-bold text-xs uppercase hover:bg-slate-50 transition-all hidden font-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg> Pelacakan Tiket
                </button>
                <button onclick="app.setSection('chat')" id="nav-chat" class="w-full flex items-center gap-4 p-4 rounded-2xl text-slate-400 font-bold text-xs uppercase hover:bg-slate-50 transition-all hidden font-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg> <span id="chat-label">Chat Admin</span>
                </button>
                <button onclick="app.printStatement()" id="nav-statement" class="w-full flex items-center gap-4 p-4 rounded-2xl text-slate-400 font-bold text-xs uppercase hover:bg-slate-50 transition-all hidden font-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg> Rekening Koran
                </button>
            </div>
        </nav>

        <div class="pt-8 border-t space-y-4 font-black">
            <button onclick="app.toggleStaffLogin(true)" id="btn-goto-staff" class="w-full py-5 bg-slate-900 text-white rounded-[1.5rem] font-black text-[11px] uppercase tracking-widest shadow-xl active:scale-95 transition-all">Akses Petugas</button>
            <button onclick="app.logout()" id="btn-logout" class="hidden w-full py-4 text-red-500 font-black text-[11px] uppercase tracking-widest">Logout</button>
        </div>
    </aside>

    <!-- 2. AUTHENTICATION PAGES -->
    <div id="view-auth" class="min-h-screen bg-btn-blue flex flex-col items-center justify-center p-6 relative overflow-hidden">
        <button onclick="app.toggleSidebar()" class="absolute top-8 left-8 p-3 bg-white/10 hover:bg-white/20 rounded-2xl text-white transition-all shadow-lg z-50">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>

        <div class="bg-white w-full max-w-md rounded-[3rem] shadow-2xl p-12 relative z-10 animate-in text-slate-800 text-center font-black">
            <div class="w-20 h-20 bg-btn-yellow rounded-2xl flex items-center justify-center text-btn-blue font-black text-3xl mx-auto mb-10 shadow-xl font-black">BTN</div>
            
            <div id="auth-nasabah">
                <h1 class="text-3xl font-black text-btn-blue uppercase tracking-tighter mb-2 leading-none font-black font-black">Portal Nasabah</h1>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-10 leading-none font-black">Digital Loan Service</p>
                <div class="space-y-4 text-left font-black">
                    <input type="text" id="n-rek" placeholder="Nomor Rekening" class="w-full p-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold focus:border-btn-blue outline-none transition-all text-slate-800 font-black">
                    <input type="password" id="n-pass" placeholder="Password" class="w-full p-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold focus:border-btn-blue outline-none transition-all text-slate-800 font-black">
                    <button onclick="app.loginNasabah()" class="w-full bg-btn-blue text-white py-5 rounded-2xl font-black shadow-2xl hover:bg-btn-dark transition-all uppercase text-xs tracking-widest mt-6 font-black font-black font-black">Masuk</button>
                    <button onclick="app.toggleRegister(true)" class="w-full text-slate-400 text-[10px] font-black uppercase tracking-widest mt-4 hover:text-btn-blue transition-all font-black">Buat Akun Baru</button>
                </div>
            </div>

            <div id="auth-register" class="hidden font-black">
                <h1 class="text-3xl font-black text-btn-blue uppercase tracking-tighter mb-10 leading-none font-black font-black">Pendaftaran</h1>
                <div class="space-y-4 font-bold text-left text-slate-800 font-black">
                    <input type="text" id="reg-name" placeholder="Nama Lengkap" class="w-full p-5 bg-slate-50 border-2 border-slate-100 rounded-2xl outline-none uppercase font-black">
                    <input type="tel" id="reg-phone" placeholder="Nomor Telepon / WA" class="w-full p-5 bg-slate-50 border-2 border-slate-100 rounded-2xl outline-none font-black">
                    <input type="text" id="reg-rek" placeholder="Set Nomor Rekening" class="w-full p-5 bg-slate-50 border-2 border-slate-100 rounded-2xl outline-none font-black">
                    <input type="password" id="reg-pass" placeholder="Set Password" class="w-full p-5 bg-slate-50 border-2 border-slate-100 rounded-2xl outline-none font-black">
                    <button onclick="app.register()" class="w-full bg-btn-yellow text-btn-blue py-5 rounded-2xl font-black shadow-xl uppercase text-xs mt-6 font-black font-black">Simpan Akun</button>
                    <button onclick="app.toggleRegister(false)" class="w-full text-slate-400 text-[10px] font-black uppercase tracking-widest mt-4 hover:text-btn-blue transition-all font-black font-black">Batal</button>
                </div>
            </div>

            <div id="auth-staff" class="hidden font-black">
                <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tight mb-10 leading-none font-black font-black font-black font-black">Otentikasi Petugas</h1>
                <div class="space-y-4 mt-8 font-black text-left">
                    <select id="s-username" class="w-full p-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-black outline-none uppercase text-xs appearance-none text-slate-800 font-black">
                        <option value="admin">ADMIN (LOAN SERVICE)</option>
                        <option value="ld">DIVISI LOAN DOKUMEN</option>
                        <option value="bcu">DIVISI BRANCH CONSUMER</option>
                        <option value="head">BRANCH MANAGER</option>
                    </select>
                    <input type="password" id="s-pass" placeholder="PIN TOKEN" class="w-full p-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-black outline-none text-center text-3xl tracking-[1em] text-slate-800">
                    <button onclick="app.loginStaff()" class="w-full bg-slate-900 text-white py-5 rounded-2xl font-black shadow-2xl uppercase text-xs mt-6 font-black font-black font-black">Verifikasi Akses</button>
                    <button onclick="app.toggleStaffLogin(false)" class="w-full text-slate-400 text-[10px] font-black uppercase tracking-widest mt-4 font-black">Kembali</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. MAIN APP DASHBOARD -->
    <div id="main-app" class="hidden min-h-screen flex flex-col font-black">
        <header class="bg-white border-b px-6 md:px-12 py-5 flex justify-between items-center sticky top-0 z-50 shadow-sm text-slate-800 font-black">
            <div class="flex items-center gap-8 font-black font-black">
                <button onclick="app.toggleSidebar()" class="p-2 hover:bg-slate-100 rounded-xl transition-all">
                    <svg class="w-8 h-8 text-btn-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-btn-blue rounded-xl flex items-center justify-center text-white font-black text-xl font-black font-black">B</div>
                    <span class="font-black text-xl tracking-tighter uppercase hidden sm:block">Digital <span class="text-slate-300">Loan Service</span></span>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <div class="text-right hidden sm:block">
                    <p id="display-role" class="text-[10px] font-black text-btn-blue uppercase tracking-[0.2em] font-black">ROLE</p>
                    <p id="display-name" class="text-sm font-black text-slate-800 uppercase font-black font-black font-black">User Name</p>
                </div>
                <div class="w-12 h-12 bg-slate-100 border-2 border-slate-50 rounded-full flex items-center justify-center font-black text-slate-400 text-lg shadow-inner font-black font-black font-black">U</div>
            </div>
        </header>

        <div class="flex-grow flex flex-col bg-white overflow-y-auto custom-scroll text-slate-800 font-black">
            
            <div id="pane-list" class="view-pane flex-grow flex flex-col animate-in">
                <div class="px-8 md:px-12 py-5 flex items-center justify-between border-b bg-slate-50/30">
                    <div class="flex items-center gap-6">
                        <button onclick="app.showCompose()" id="btn-add" class="bg-btn-blue text-white px-8 py-3 rounded-full text-[10px] font-black uppercase shadow-lg hidden font-black font-black font-black">+ Buat Laporan</button>
                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest font-black font-black font-black">SLA Target: <span class="text-green-600 font-black font-black font-black font-black font-black">1x24 JAM</span></p>
                    </div>
                </div>
                <div id="complaint-list" class="divide-y overflow-y-auto font-black"></div>
            </div>

            <!-- LIVE CHAT -->
            <div id="pane-chat" class="view-pane hidden h-full flex flex-col bg-slate-50 animate-in p-6 lg:p-10 font-black">
                <div class="bg-white border-2 border-slate-100 rounded-[3rem] shadow-xl flex-grow flex flex-col overflow-hidden">
                    <div class="bg-slate-900 text-white p-8 flex justify-between items-center font-black">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-btn-blue rounded-full flex items-center justify-center font-black text-white font-black font-black font-black font-black font-black">?</div>
                            <div>
                                <p class="text-sm font-black uppercase tracking-widest" id="chat-with-name">Customer Service Center</p>
                                <p class="text-[10px] opacity-60 uppercase font-black font-black font-black font-black font-black">Digital Office Bank BTN</p>
                            </div>
                        </div>
                        <span class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
                    </div>
                    <div id="chat-box" class="flex-grow p-10 overflow-y-auto space-y-6 font-bold text-sm bg-slate-50/50 flex flex-col font-black font-black font-black"></div>
                    <div class="p-8 border-t-2 bg-white flex gap-6 font-black">
                        <input type="text" id="chat-input" placeholder="Tuliskan pesan..." class="flex-grow p-5 rounded-3xl border-2 outline-none focus:border-btn-blue font-bold text-slate-800 font-black font-black font-black font-black">
                        <button onclick="app.sendChat()" class="bg-btn-blue text-white px-12 rounded-3xl font-black text-xs uppercase shadow-xl hover:scale-105 transition-all font-black font-black">Kirim</button>
                    </div>
                </div>
            </div>

            <!-- FORM PENGADUAN -->
            <div id="pane-compose" class="view-pane hidden p-12 lg:p-20 max-w-5xl mx-auto w-full animate-in font-black">
                <h2 class="text-4xl font-black text-btn-blue mb-12 uppercase tracking-tighter font-black font-black font-black">Sampaikan Kendala</h2>
                <div class="space-y-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 font-bold">
                        <div class="space-y-3 font-black"><label class="text-[11px] font-black text-slate-400 uppercase font-black font-black">Kategori</label><select id="f-cat" class="w-full p-6 bg-slate-50 border-2 rounded-[2rem] outline-none text-slate-800 font-black font-black font-black"><option value="umum">MASALAH UMUM</option><option value="dokumen">DOKUMEN & SERTIFIKAT</option><option value="kredit">KREDIT & ANGSURAN</option></select></div>
                        <div class="space-y-3 font-black"><label class="text-[11px] font-black text-slate-400 uppercase font-black font-black font-black">Subjek</label><input type="text" id="f-title" class="w-full p-6 bg-slate-50 border-2 rounded-[2rem] outline-none uppercase text-slate-800 font-black font-black font-black" placeholder="MISAL: KPR"></div>
                    </div>
                    <div class="space-y-3 font-black font-black font-black"><label class="text-[11px] font-black text-slate-400 uppercase font-black font-black font-black font-black">Kronologi</label><textarea id="f-desc" class="w-full p-10 bg-slate-50 border-2 rounded-[3rem] h-56 font-bold outline-none shadow-inner text-slate-800 font-black font-black font-black font-black" placeholder="Jelaskan detail..."></textarea></div>
                    
                    <div class="space-y-4 font-black">
                        <label class="text-[11px] font-black text-slate-400 uppercase font-black font-black ml-2 font-black font-black font-black font-black font-black">Lampiran Dokumen (Foto/PDF)</label>
                        <div class="flex items-center justify-center w-full font-black">
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-100 border-dashed rounded-[2.5rem] cursor-pointer bg-slate-50 hover:bg-slate-100 transition-all font-black font-black font-black">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 text-slate-400 font-black font-black font-black font-black font-black">
                                    <svg class="w-8 h-8 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p id="file-label" class="text-xs uppercase tracking-widest font-black font-black font-black font-black font-black font-black">Klik untuk Upload File Pendukung</p>
                                </div>
                                <input id="f-file" type="file" class="hidden" onchange="app.handleFileSelection(this)" accept="image/*,.pdf" />
                            </label>
                        </div>
                    </div>

                    <button type="button" onclick="app.submitTicket()" class="w-full bg-btn-blue text-white py-8 rounded-[2.5rem] font-black shadow-2xl uppercase tracking-[0.3em] font-black font-black font-black font-black font-black font-black font-black font-black font-black">Kirim Laporan Resmi</button>
                </div>
            </div>

            <div id="pane-detail" class="view-pane hidden p-12 lg:p-20 animate-in text-slate-800 font-black font-black font-black font-black font-black font-black font-black">
                <button onclick="app.setSection('inbox')" class="mb-12 text-xs font-black text-slate-300 uppercase flex items-center gap-3 hover:text-btn-blue font-black font-black font-black font-black font-black font-black font-black font-black font-black">← KEMBALI KE DAFTAR</button>
                <div id="detail-content" class="max-w-5xl font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black"></div>
            </div>

            <div id="pane-tracking" class="view-pane hidden p-12 lg:p-20 max-w-5xl mx-auto w-full animate-in font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black">
                <h2 class="text-4xl font-black text-btn-blue mb-16 uppercase tracking-tighter font-black font-black font-black font-black font-black font-black font-black font-black font-black">Tracking Laporan</h2>
                <div id="tracking-list" class="space-y-12 font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black"></div>
            </div>
        </div>
    </div>

    <!-- MODAL RESOLUSI -->
    <div id="resolve-modal" class="hidden fixed inset-0 z-[120] flex items-center justify-center glass-overlay px-4 overflow-y-auto py-10 font-black font-black font-black font-black font-black font-black">
        <div class="bg-white p-12 md:p-16 rounded-[4rem] shadow-2xl max-w-2xl w-full border-t-[16px] border-green-500 shadow-green-600/20 animate-in text-slate-800 font-black">
            <h3 class="text-3xl font-black uppercase mb-4 tracking-tighter leading-none font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black">Otorisasi Solusi</h3>
            <div class="space-y-10 font-black">
                <div class="grid grid-cols-3 gap-4">
                    <button onclick="app.setRes('ringan')" id="r-ringan" class="py-5 border-2 rounded-2xl text-[10px] font-black uppercase transition-all shadow-sm font-black font-black font-black font-black font-black font-black font-black font-black font-black">Chat</button>
                    <button onclick="app.setRes('berat')" id="r-berat" class="py-5 border-2 rounded-2xl text-[10px] font-black uppercase transition-all shadow-sm font-black font-black font-black font-black font-black font-black font-black font-black font-black">Call</button>
                    <button onclick="app.setRes('meet')" id="r-meet" class="py-5 border-2 rounded-2xl text-[10px] font-black uppercase transition-all shadow-sm font-black font-black font-black font-black font-black font-black font-black font-black font-black">Meet</button>
                </div>
                <div id="box-ringan" class="space-y-4">
                    <p class="text-[11px] font-black text-blue-500 uppercase ml-2 underline underline-offset-8 decoration-2 font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black">Balasan Website</p>
                    <textarea id="h-text" class="w-full p-8 bg-slate-50 border-2 rounded-[2.5rem] h-32 text-sm font-black focus:border-btn-blue outline-none shadow-inner font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black" placeholder="Pesan untuk nasabah..."></textarea>
                </div>
                <div id="box-berat" class="hidden p-10 bg-orange-50 border-2 border-orange-100 rounded-[2.5rem] text-center font-black">
                    <p class="text-4xl font-black text-slate-800 tracking-widest font-sans font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black" id="target-phone-display">08xxx</p>
                    <a id="wa-btn" target="_blank" class="mt-6 inline-block bg-green-600 text-white px-10 py-4 rounded-full text-[10px] font-black uppercase shadow-lg hover:bg-green-700 font-black font-black font-black font-black font-black font-black font-black font-black font-black">Hubungi WA Nasabah</a>
                </div>
                <div id="box-meet" class="hidden p-10 bg-blue-50 border-2 border-blue-100 rounded-[3rem] space-y-10 font-black">
                    <div class="grid grid-cols-2 gap-10 font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black">
                        <div class="space-y-2 font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black"><label class="text-[9px] font-black text-blue-400 uppercase font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black">Waktu</label><input type="datetime-local" id="h-date" class="w-full p-3 rounded-xl text-xs font-black border-2 border-blue-200 text-slate-800 font-black font-black font-black font-black font-black font-black font-black"></div>
                        <div class="space-y-2 font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black"><label class="text-[9px] font-black text-blue-400 uppercase font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black">Lokasi</label><input type="text" id="h-place" placeholder="Ruang Branch Manager" class="w-full p-3 rounded-xl text-xs font-black border-2 border-blue-200 uppercase text-slate-800 font-black font-black font-black font-black font-black font-black font-black font-black"></div>
                    </div>
                </div>
                <div class="flex gap-8 pt-10 border-t">
                    <button onclick="app.closeResolve()" class="flex-1 py-6 text-xs font-black uppercase text-slate-300 hover:text-red-500 transition-colors uppercase font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black">Batal</button>
                    <button onclick="app.confirmResolve()" class="flex-[2] py-6 bg-green-600 text-white rounded-[2rem] font-black uppercase shadow-2xl active:scale-95 transition-all text-white font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black">Selesaikan Kasus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PDF -->
    <div id="print-modal" class="hidden fixed inset-0 z-[120] bg-white p-12 overflow-y-auto font-black font-black">
        <div class="max-w-5xl mx-auto border-4 p-12 md:p-20 shadow-2xl rounded-[4rem] text-slate-800 font-black bg-white">
            <div class="flex justify-between border-b-8 border-btn-blue pb-12 mb-12 font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black"><div class="w-24 h-24 bg-btn-blue text-white flex items-center justify-center font-black text-5xl rounded-3xl italic font-black font-black font-black font-black">B</div><div class="text-right font-black font-black font-black"><h1 class="text-4xl uppercase italic font-black font-black font-black font-black font-black font-black font-black">Rekening Koran</h1><p class="text-xs uppercase opacity-30 mt-2 font-black font-black">Periode: April 2026</p></div></div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-20 font-black font-black font-black font-black font-black font-black">
                <div>
                    <p class="text-[11px] font-black text-slate-400 uppercase font-black font-black font-black font-black font-black">Nasabah</p>
                    <p id="p-name" class="text-2xl font-black border-b-4 pb-2 uppercase text-slate-800 font-black font-black font-black font-black font-black font-black font-black">ANWAR HAKIM</p>
                </div>
                <div class="text-right font-black">
                    <p class="text-[11px] font-black text-slate-400 uppercase font-black font-black font-black font-black font-black">No. Rekening</p>
                    <p id="p-rek" class="text-2xl font-black border-b-4 pb-2 text-slate-800 font-black font-black font-black font-black font-black font-black font-black">1209.1100.888</p>
                </div>
            </div>

            <table class="w-full text-sm mb-16 font-black">
                <thead class="bg-slate-900 text-white uppercase text-[10px] font-black tracking-widest"><th class="py-6 px-6 text-left font-black">Tanggal</th><th class="py-6 px-6 text-left font-black">Keterangan Transaksi</th><th class="py-6 px-6 text-right font-black">Debit</th><th class="py-6 px-6 text-right font-black">Kredit</th><th class="py-6 px-6 text-right font-black">Saldo</th></thead>
                <tbody class="divide-y-2 border-b-2 font-bold text-slate-600 uppercase text-[11px] font-black">
                    <tr><td class="py-6 px-6 text-slate-400 font-black">01/04/26</td><td class="py-6 px-6 font-black">SALDO AWAL TERHITUNG</td><td class="py-6 px-6 text-right font-black">-</td><td class="py-6 px-6 text-right font-black">-</td><td class="py-6 px-6 text-right text-slate-800 font-black font-black">250.000.000</td></tr>
                    <tr class="bg-slate-50/50"><td class="py-6 px-6 text-slate-400 font-black">05/04/26</td><td class="py-6 px-6 text-slate-800 font-black">TRF MASUK - BP KPR NASABAH</td><td class="py-6 px-6 text-right font-black">-</td><td class="py-6 px-6 text-right text-green-600 font-black font-black">5.000.000</td><td class="py-6 px-6 text-right text-slate-800 font-black font-black">255.000.000</td></tr>
                    <tr><td class="py-6 px-6 text-slate-400 font-black">10/04/26</td><td class="py-6 px-6 text-slate-800 font-black">BY ADM BULANAN TABUNGAN</td><td class="py-6 px-6 text-right text-red-600 font-black font-black">15.000</td><td class="py-6 px-6 text-right font-black">-</td><td class="py-6 px-6 text-right text-slate-800 font-black font-black">254.985.000</td></tr>
                    <tr class="bg-slate-50/50"><td class="py-6 px-6 text-slate-400 font-black">12/04/26</td><td class="py-6 px-6 text-slate-800 font-black">TARIK TUNAI ATM BTN-JKT</td><td class="py-6 px-6 text-right text-red-600 font-black font-black">1.000.000</td><td class="py-6 px-6 text-right font-black">-</td><td class="py-6 px-6 text-right text-slate-800 font-black font-black">253.985.000</td></tr>
                    <tr><td class="py-6 px-6 text-slate-400 font-black">20/04/26</td><td class="py-6 px-6 text-slate-800 font-black">BUNGA TABUNGAN (CREDIT)</td><td class="py-6 px-6 text-right font-black">-</td><td class="py-6 px-6 text-right text-green-600 font-black font-black">125.000</td><td class="py-6 px-6 text-right text-slate-800 font-black font-black">254.110.000</td></tr>
                    <tr class="bg-slate-50/50"><td class="py-6 px-6 text-slate-400 font-black">25/04/26</td><td class="py-6 px-6 text-red-600 font-black font-black font-black">AUTODEBET CICILAN KPR BTN</td><td class="py-6 px-6 text-right text-red-600 font-black font-black">2.500.000</td><td class="py-6 px-6 text-right font-black">-</td><td class="py-6 px-6 text-right text-slate-800 font-black font-black font-black">251.610.000</td></tr>
                </tbody>
            </table>

            <div class="no-print flex justify-end gap-6 font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black">
                <button onclick="document.getElementById('print-modal').classList.add('hidden')" class="px-10 py-4 bg-slate-100 rounded-2xl uppercase text-xs font-black font-black font-black">Tutup</button>
                <!-- DIUBAH MENJADI DOWNLOAD MUTASI SESUAI PERMINTAAN -->
                <button onclick="window.print()" class="px-10 py-4 bg-btn-blue text-white rounded-2xl uppercase text-xs shadow-2xl font-black font-black font-black font-black">Download Mutasi</button>
            </div>
        </div>
    </div>

    <div id="toast" class="fixed bottom-12 left-1/2 -translate-x-1/2 bg-slate-900 text-white px-10 py-5 rounded-[2rem] shadow-2xl text-[11px] font-black uppercase tracking-widest z-[200] hidden font-black font-black font-black font-black font-black font-black">Berhasil</div>

    <script>
        const app = {
            state: {
                users: [{ name: 'Anwar Hakim', rek: '123', pass: '123', phone: '08123456789' }],
                currentUser: null,
                role: 'nasabah',
                tickets: [{ id: 'TKT-4491', name: 'ANWAR HAKIM', phone: '08123456789', title: 'SERTIFIKAT BELUM TERBIT', desc: 'KPR sudah lunas tapi dokumen belum diserahkan.', cat: 'dokumen', status: 'new', handler: 'admin', time: '14:20', attachment: null }],
                chats: [{ role: 'admin', text: 'Halo, tim Loan Service siap membantu.', from: 'ADMIN', time: '09:00' }],
                tempFile: null
            },

            init() { this.renderList(); },

            // --- AUTH & LOGOUT ---
            toggleRegister(show) { document.getElementById('auth-nasabah').classList.toggle('hidden', show); document.getElementById('auth-register').classList.toggle('hidden', !show); },
            toggleStaffLogin(show) {
                document.getElementById('auth-nasabah').classList.add('hidden');
                document.getElementById('auth-register').classList.add('hidden');
                document.getElementById('auth-staff').classList.toggle('hidden', !show);
                if(!show) document.getElementById('auth-nasabah').classList.remove('hidden');
                if(show && document.getElementById('sidebar').classList.contains('open')) this.toggleSidebar();
            },
            register() {
                const name = document.getElementById('reg-name').value;
                const phone = document.getElementById('reg-phone').value;
                const rek = document.getElementById('reg-rek').value;
                const pass = document.getElementById('reg-pass').value;
                if(!rek || !pass || !phone) return;
                this.state.users.push({ name, rek, pass, phone });
                alert('Pendaftaran Berhasil! Silakan Login.'); this.toggleRegister(false);
            },
            loginNasabah() {
                const rek = document.getElementById('n-rek').value;
                const pass = document.getElementById('n-pass').value;
                const user = this.state.users.find(u => u.rek === rek && u.pass === pass);
                if(user) { this.state.currentUser = user; this.state.role = 'nasabah'; this.enterApp(); } else { alert('Gagal Login!'); }
            },
            loginStaff() {
                const user = document.getElementById('s-username').value;
                const pin = document.getElementById('s-pass').value;
                const tokens = { admin: '123', ld: '456', bcu: '789', head: '000' };
                if(pin === tokens[user]) { this.state.role = user; this.state.currentUser = { name: user.toUpperCase(), rek: 'STAFF', phone: 'INTERNAL' }; this.enterApp(); } else { alert('PIN Salah!'); }
            },
            enterApp() {
                document.getElementById('view-auth').classList.add('hidden');
                document.getElementById('main-app').classList.remove('hidden');
                document.getElementById('display-role').innerText = (this.state.role === 'head' ? 'BRANCH MANAGER' : this.state.role.toUpperCase());
                document.getElementById('display-name').innerText = this.state.currentUser.name;
                const isNasabah = (this.state.role === 'nasabah');
                document.getElementById('nav-tracking').classList.toggle('hidden', !isNasabah);
                document.getElementById('nav-statement').classList.toggle('hidden', !isNasabah);
                document.getElementById('nav-chat').classList.toggle('hidden', !isNasabah && this.state.role !== 'admin');
                document.getElementById('chat-label').innerText = isNasabah ? "Chat Admin" : "Live Chat Center";
                document.getElementById('btn-add').classList.toggle('hidden', !isNasabah);
                
                // AKSES PETUGAS HILANG DI HALAMAN DALAM
                document.getElementById('btn-goto-staff').classList.add('hidden');
                
                document.getElementById('btn-logout').classList.remove('hidden');
                this.setSection('inbox');
            },
            logout() {
                this.state.currentUser = null;
                this.state.role = 'nasabah';
                document.getElementById('main-app').classList.add('hidden');
                document.getElementById('view-auth').classList.remove('hidden');
                document.getElementById('btn-goto-staff').classList.remove('hidden');
                this.notify('Logged Out');
            },

            // --- NAV ---
            toggleSidebar() { document.getElementById('sidebar').classList.toggle('open'); document.getElementById('sidebar-overlay').classList.toggle('hidden'); },
            setSection(sec) {
                document.querySelectorAll('.view-pane').forEach(p => p.classList.add('hidden'));
                if(sec === 'inbox') { document.getElementById('pane-list').classList.remove('hidden'); this.renderList(); }
                else if(sec === 'tracking') { document.getElementById('pane-tracking').classList.remove('hidden'); this.renderTracking(); }
                else if(sec === 'chat') { document.getElementById('pane-chat').classList.remove('hidden'); this.renderChat(); }
                if(document.getElementById('sidebar').classList.contains('open')) this.toggleSidebar();
            },
            showCompose() { document.querySelectorAll('.view-pane').forEach(p => p.classList.add('hidden')); document.getElementById('pane-compose').classList.remove('hidden'); },

            // --- FILE ---
            handleFileSelection(input) {
                const file = input.files[0];
                if (file) {
                    document.getElementById('file-label').innerText = `TERPILIH: ${file.name.toUpperCase()}`;
                    const reader = new FileReader();
                    reader.onload = (e) => { this.state.tempFile = { name: file.name, data: e.target.result }; };
                    reader.readAsDataURL(file);
                }
            },

            // --- TICKETS ---
            submitTicket() {
                const title = document.getElementById('f-title').value; const desc = document.getElementById('f-desc').value;
                if(!title || !desc) return;
                this.state.tickets.unshift({ 
                    id: 'TKT-' + Math.floor(1000 + Math.random() * 9000), 
                    name: this.state.currentUser.name.toUpperCase(), 
                    phone: this.state.currentUser.phone,
                    title: title.toUpperCase(), 
                    cat: document.getElementById('f-cat').value, 
                    status: 'new', handler: 'admin', 
                    time: new Date().toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit'}), 
                    desc, 
                    attachment: this.state.tempFile 
                });
                this.state.tempFile = null; document.getElementById('file-label').innerText = "Klik untuk Upload File Pendukung";
                this.notify('Laporan Terkirim'); this.setSection('inbox');
            },
            renderList() {
                const list = document.getElementById('complaint-list'); list.innerHTML = '';
                let f = this.state.tickets;
                if(this.state.role === 'nasabah') f = this.state.tickets.filter(t => t.name.toUpperCase() === this.state.currentUser.name.toUpperCase());
                else if(['admin', 'ld', 'bcu'].includes(this.state.role)) f = this.state.tickets.filter(t => t.handler === this.state.role);
                else if(this.state.role === 'head') f = this.state.tickets.filter(t => t.handler === 'head' || t.status === 'processing' || t.status === 'resolved');
                
                if(!f.length) { list.innerHTML = `<p class="p-20 text-center opacity-20 font-black text-xl font-black font-black">KOTAK MASUK KOSONG</p>`; return; }
                f.forEach(t => {
                    const row = document.createElement('div');
                    row.className = `gmail-row flex items-center gap-8 px-10 py-10 border-b cursor-pointer transition-all ${t.status === 'new' || t.status === 'processing' ? 'bg-white font-black' : 'bg-slate-50 opacity-70 font-black'}`;
                    row.onclick = () => this.showDetail(t.id);
                    row.innerHTML = `<div class="w-56 text-[11px] font-black uppercase text-slate-400 font-black">#${t.id} - ${t.name}</div><div class="flex-grow truncate font-black font-black"><span class="text-sm uppercase font-black font-black tracking-tight font-black font-black">${t.title} ${t.attachment ? '📎' : ''}</span><span class="text-[10px] text-slate-400 ml-4 font-bold">- ${t.desc}</span></div><div class="w-24 text-right text-[10px] text-slate-400 font-black uppercase font-black font-black">${t.time}</div>`;
                    list.appendChild(row);
                });
            },
            showDetail(id) {
                const t = this.state.tickets.find(x => x.id === id);
                document.querySelectorAll('.view-pane').forEach(p => p.classList.add('hidden'));
                document.getElementById('pane-detail').classList.remove('hidden');
                let btns = '';
                if(this.state.role === 'admin' && t.status === 'new') btns = `<div class="flex gap-4 pt-10 border-t font-black font-black font-black"><button onclick="app.forward('${t.id}', 'ld')" class="px-8 py-5 bg-btn-blue text-white rounded-3xl font-black text-[10px] uppercase shadow-xl font-black font-black">Forward LD</button><button onclick="app.forward('${t.id}', 'bcu')" class="px-8 py-5 bg-btn-blue text-white rounded-3xl font-black text-[10px] uppercase shadow-xl font-black font-black">Forward BCU</button><button onclick="app.forward('${t.id}', 'head')" class="px-8 py-5 bg-slate-900 text-white rounded-3xl font-black text-[10px] uppercase shadow-xl font-black font-black font-black">Forward Manager</button><button onclick="app.openResolve('${t.id}')" class="px-8 py-5 bg-green-600 text-white rounded-3xl font-black text-[10px] uppercase shadow-xl font-black font-black font-black">Selesaikan</button></div>`;
                else if((this.state.role === 'ld' || this.state.role === 'bcu') && t.status === 'reviewed') btns = `<button onclick="app.openResolve('${t.id}')" class="mt-10 px-10 py-5 bg-green-600 text-white rounded-3xl font-black text-[10px] uppercase shadow-xl font-black font-black font-black">Selesaikan Kasus</button>`;
                else if(this.state.role === 'head' && (t.status === 'processing' || t.handler === 'head')) btns = `<button onclick="app.openResolve('${t.id}')" class="mt-10 px-12 py-6 bg-green-600 text-white rounded-3xl font-black text-[10px] uppercase shadow-2xl font-black font-black font-black font-black font-black">Otorisasi Manager</button>`;
                
                let fileS = t.attachment ? `<div class="mt-6 p-6 bg-blue-50 border-2 border-blue-100 rounded-3xl flex items-center justify-between font-black font-black"><div class="flex items-center gap-4"><span class="text-2xl">📄</span><div><p class="text-[10px] text-slate-400 font-black uppercase font-black font-black">Dokumen Pendukung:</p><p class="text-xs text-btn-blue font-black uppercase font-black">${t.attachment.name}</p></div></div><a href="${t.attachment.data}" download="${t.attachment.name}" class="bg-btn-blue text-white px-6 py-2.5 rounded-full text-[9px] font-black uppercase font-black shadow-lg">Buka File</a></div>` : '';

                document.getElementById('detail-content').innerHTML = `
                    <div class="bg-white"><h1 class="text-4xl font-black uppercase text-slate-800 mb-6 font-black font-black font-black">${t.title}</h1>
                    <div class="flex items-center gap-6 mb-8 font-black font-black"><div class="w-16 h-16 bg-slate-200 rounded-3xl flex items-center justify-center font-black text-2xl text-slate-400 font-black font-black">U</div>
                    <div><p class="font-black uppercase text-sm">${t.name}</p><p class="text-[11px] text-green-600 font-bold uppercase font-black font-black">TELP: ${t.phone}</p></div></div>
                    <div class="bg-slate-50 p-12 rounded-[3rem] text-sm leading-loose border-2 border-slate-100 italic font-bold text-slate-600 shadow-inner font-black font-black font-black">"${t.desc}"</div>${fileS}${btns}</div>`;
            },
            forward(id, target) { const t = this.state.tickets.find(x => x.id === id); t.handler = target; t.status = (target === 'head' ? 'processing' : 'reviewed'); this.notify('Diteruskan'); this.setSection('inbox'); },
            openResolve(id) { 
                this.state.activeTicketId = id; 
                const t = this.state.tickets.find(x => x.id === id); 
                document.getElementById('target-phone-display').innerText = t.phone; 
                document.getElementById('wa-btn').href = `https://wa.me/${t.phone.replace(/[^0-9]/g, '')}`;
                document.getElementById('resolve-modal').classList.remove('hidden'); 
                this.setRes('ringan'); 
            },
            setRes(type) { this.state.resType = type; ['ringan', 'berat', 'meet'].forEach(t => { const btn = document.getElementById(`r-${t}`); const box = document.getElementById(`box-${t}`); if(t === type) { btn.className = "py-5 border-2 border-btn-blue bg-blue-50 text-btn-blue text-[10px] font-black uppercase shadow-md font-black font-black"; box.classList.remove('hidden'); } else { btn.className = "py-5 border-2 border-slate-100 rounded-2xl text-[10px] font-black uppercase text-slate-400 font-black font-black font-black"; box.classList.add('hidden'); } }); },
            closeResolve() { document.getElementById('resolve-modal').classList.add('hidden'); },
            confirmResolve() { const t = this.state.tickets.find(x => x.id === this.state.activeTicketId); t.status = 'resolved'; t.resData = { type: this.state.resType, text: document.getElementById('h-text').value, date: document.getElementById('h-date').value, place: document.getElementById('h-place').value }; this.notify('Selesai'); this.setSection('inbox'); this.closeResolve(); },
            renderChat() {
                const box = document.getElementById('chat-box'); box.innerHTML = '';
                const title = document.getElementById('chat-with-name'); title.innerText = this.state.role === 'nasabah' ? "ADMIN LOAN SERVICE (BTN)" : "INBOX CHAT NASABAH";
                this.state.chats.forEach(c => { const isMe = (this.state.role === 'admin' && c.role === 'admin') || (this.state.role === 'nasabah' && c.role === 'nasabah'); const el = document.createElement('div'); el.className = `flex flex-col ${isMe ? 'items-end' : 'items-start animate-in'}`; el.innerHTML = `<span class="text-[9px] text-slate-400 mb-1 uppercase tracking-widest font-black font-black font-black">${c.from} • ${c.time}</span><div class="${isMe ? 'bg-btn-blue text-white rounded-3xl rounded-tr-none' : 'bg-white border-2 border-slate-100 rounded-3xl rounded-tl-none'} p-5 max-w-xl shadow-sm text-sm font-black font-black font-black">${c.text}</div>`; box.appendChild(el); }); box.scrollTop = box.scrollHeight;
            },
            sendChat() { const input = document.getElementById('chat-input'); if(!input.value) return; this.state.chats.push({ role: this.state.role === 'admin' ? 'admin' : 'nasabah', from: this.state.currentUser.name, text: input.value, time: new Date().toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'}) }); input.value = ''; this.renderChat(); },
            renderTracking() {
                const cont = document.getElementById('tracking-list'); cont.innerHTML = '';
                this.state.tickets.filter(t => t.name === this.state.currentUser.name.toUpperCase()).forEach(t => {
                    const states = ['new', 'reviewed', 'resolved']; const curr = states.indexOf(t.status === 'resolved' ? 'resolved' : (t.status === 'new' ? 'new' : 'reviewed'));
                    const card = document.createElement('div'); card.className = `p-12 rounded-[4rem] border-2 shadow-xl animate-in ${t.status === 'resolved' ? 'bg-green-50 border-green-100' : 'bg-white border-slate-50'} font-black mb-10 font-black font-black font-black`;
                    let stps = ''; states.forEach((s, i) => { const act = i <= curr ? 'dot-active' : ''; stps += `<div class="flex flex-col items-center gap-4 flex-1 relative z-10 font-black font-black font-black"><div class="tracking-dot ${act}"></div><span class="text-[9px] font-black uppercase text-slate-400 tracking-tighter font-black font-black font-black">${s.replace('new', 'Submitted')}</span></div>`; });
                    let resMarkup = (t.status === 'resolved' && t.resData) ? `<div class="mt-8 pt-8 border-t-2 border-green-200 font-black font-black font-black font-black font-black font-black">${t.resData.type === 'ringan' ? `<p class="text-sm font-black text-green-900 bg-white p-8 rounded-3xl border border-green-100 italic shadow-inner font-black font-black font-black font-black">" ${t.resData.text} "</p>` : t.resData.type === 'berat' ? `<p class="mt-8 bg-orange-50 p-8 rounded-3xl text-orange-700 font-black uppercase text-[11px] tracking-widest text-center border border-orange-100 font-black font-black font-black font-black font-black">📞 PETUGAS AKAN MENGHUBUNGI ANDA SEGERA.</p>` : `<div class="mt-8 bg-blue-600 text-white p-10 rounded-[3rem] shadow-2xl relative overflow-hidden font-black uppercase tracking-widest text-white font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black"><span class="text-[10px] font-black opacity-60 text-white font-black font-black font-black font-black font-black">AGENDA PERTEMUAN</span><p class="text-2xl mt-4 font-black text-white font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black">${t.resData.date.replace('T', ' JAM ')}</p><p class="text-xs mt-4 font-black text-white font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black font-black">LOKASI: ${t.resData.place}</p></div>`}</div>` : '';
                    card.innerHTML = `<div class="flex justify-between items-center mb-10 pb-8 border-b-2 font-black font-black font-black font-black font-black font-black font-black"><div><p class="text-[11px] font-black text-slate-400 uppercase tracking-widest font-black font-black font-black font-black font-black font-black">TIKET ID</p><p class="text-4xl font-black text-btn-blue tracking-tighter leading-none font-black font-black font-black font-black font-black font-black font-black font-black font-black">${t.id}</p></div><div class="text-right text-[11px] font-black text-slate-400 uppercase tracking-widest font-black font-black font-black font-black font-black font-black">STATUS: <span class="text-btn-blue font-black font-black font-black font-black font-black font-black font-black font-black font-black">${t.status.toUpperCase()}</span></div></div><div class="flex justify-between relative mb-12 font-black font-black font-black font-black font-black font-black font-black font-black font-black"><div class="absolute top-[5px] left-0 right-0 h-[2px] bg-slate-100 z-0 font-black font-black font-black font-black font-black"></div>${stps}</div><h4 class="text-2xl font-black mb-6 font-black uppercase tracking-tighter font-black font-black font-black font-black font-black font-black font-black font-black font-black">${t.title}</h4>${resMarkup}`; cont.appendChild(card);
                });
            },
            printStatement() { document.getElementById('print-modal').classList.remove('hidden'); document.getElementById('p-name').innerText = this.state.currentUser.name; },
            notify(msg) { const t = document.getElementById('toast'); t.innerText = msg; t.classList.remove('hidden'); setTimeout(() => t.classList.add('hidden'), 3000); }
        };
        window.onload = () => app.init();
    </script>
</body>
</html>