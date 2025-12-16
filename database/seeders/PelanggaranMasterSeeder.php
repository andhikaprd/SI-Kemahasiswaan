<?php

namespace Database\Seeders;

use App\Models\PelanggaranMaster;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PelanggaranMasterSeeder extends Seeder
{
    /**
     * Seed master list pelanggaran.
     */
    public function run(): void
    {
        if (!Schema::hasTable('pelanggaran_masters')) {
            // Lewati bila migrasi belum dijalankan.
            return;
        }

        $items = [
            ['nama' => 'Terlambat hadir <=30 menit', 'kategori' => 'ringan', 'deskripsi' => 'Datang terlambat ke kegiatan resmi dengan jeda maksimal 30 menit tanpa alasan jelas.', 'sanksi_default' => 'Teguran lisan dan pencatatan keterlambatan.'],
            ['nama' => 'Terlambat hadir >30 menit', 'kategori' => 'sedang', 'deskripsi' => 'Datang terlambat lebih dari 30 menit atau meninggalkan kegiatan sebelum selesai tanpa izin.', 'sanksi_default' => 'Teguran tertulis dan tugas perbaikan/shift pengganti.'],
            ['nama' => 'Tidak membawa kartu identitas', 'kategori' => 'ringan', 'deskripsi' => 'Tidak membawa/memperlihatkan kartu identitas mahasiswa/panitia saat diminta.', 'sanksi_default' => 'Teguran lisan dan pengingat membawa kartu.'],
            ['nama' => 'Berpakaian tidak sesuai ketentuan', 'kategori' => 'ringan', 'deskripsi' => 'Tidak mengikuti ketentuan pakaian yang sudah diatur untuk kegiatan resmi.', 'sanksi_default' => 'Teguran lisan dan perbaikan penampilan.'],
            ['nama' => 'Tidak mengikuti kegiatan wajib', 'kategori' => 'sedang', 'deskripsi' => 'Alpa pada kegiatan wajib tanpa keterangan yang sah.', 'sanksi_default' => 'Teguran tertulis dan wajib mengganti tugas.'],
            ['nama' => 'Meninggalkan kegiatan tanpa izin', 'kategori' => 'sedang', 'deskripsi' => 'Pergi sebelum kegiatan selesai tanpa izin koordinator atau penanggung jawab.', 'sanksi_default' => 'Tugas pengganti dan evaluasi disiplin.'],
            ['nama' => 'Berisik di kelas/ruang rapat', 'kategori' => 'ringan', 'deskripsi' => 'Mengganggu ketertiban selama rapat/kegiatan dengan percakapan atau suara keras.', 'sanksi_default' => 'Peringatan lisan dan pemindahan tempat duduk.'],
            ['nama' => 'Membuang sampah sembarangan', 'kategori' => 'ringan', 'deskripsi' => 'Tidak menjaga kebersihan lingkungan kampus/kegiatan.', 'sanksi_default' => 'Kerja sosial membersihkan area kegiatan.'],
            ['nama' => 'Merokok di area terlarang', 'kategori' => 'sedang', 'deskripsi' => 'Merokok/vape di area kampus atau ruang kegiatan yang dilarang.', 'sanksi_default' => 'Teguran tertulis dan kerja sosial.'],
            ['nama' => 'Penggunaan gawai tanpa izin', 'kategori' => 'ringan', 'deskripsi' => 'Menggunakan ponsel/laptop saat sesi wajib tanpa izin pemateri.', 'sanksi_default' => 'Teguran lisan dan penyitaan sementara.'],
            ['nama' => 'Tidak menyelesaikan tugas panitia', 'kategori' => 'sedang', 'deskripsi' => 'Mengabaikan tugas kepanitiaan yang sudah disepakati tanpa koordinasi.', 'sanksi_default' => 'Surat peringatan dan penugasan ulang.'],
            ['nama' => 'Bahasa tidak sopan ke civitas', 'kategori' => 'sedang', 'deskripsi' => 'Menggunakan kata-kata kasar atau tidak menghargai dosen/panitia/peserta.', 'sanksi_default' => 'Permintaan maaf tertulis dan pembinaan etika.'],
            ['nama' => 'Plagiarisme tugas organisasi', 'kategori' => 'sedang', 'deskripsi' => 'Menyalin pekerjaan/tugas organisasi tanpa mencantumkan sumber atau izin.', 'sanksi_default' => 'Pembatalan hasil tugas dan surat peringatan.'],
            ['nama' => 'Memalsukan tanda tangan/absensi', 'kategori' => 'berat', 'deskripsi' => 'Memalsukan tanda tangan, stempel, atau data kehadiran.', 'sanksi_default' => 'Skorsing kepanitiaan dan laporan ke pihak prodi.'],
            ['nama' => 'Menyebarkan hoaks internal', 'kategori' => 'sedang', 'deskripsi' => 'Menyebarkan informasi palsu/menyesatkan yang merugikan organisasi.', 'sanksi_default' => 'Pernyataan klarifikasi dan surat peringatan.'],
            ['nama' => 'Vandalisme fasilitas kampus', 'kategori' => 'berat', 'deskripsi' => 'Merusak atau mencoret fasilitas kampus/organisasi.', 'sanksi_default' => 'Ganti rugi kerusakan dan skorsing kegiatan.'],
            ['nama' => 'Berkelahi di lingkungan kampus', 'kategori' => 'berat', 'deskripsi' => 'Melakukan kekerasan fisik atau perkelahian.', 'sanksi_default' => 'Skorsing dan rekomendasi tindak lanjut disiplin kampus.'],
            ['nama' => 'Mengonsumsi atau membawa alkohol', 'kategori' => 'berat', 'deskripsi' => 'Mengonsumsi/membawa minuman beralkohol di lingkungan kampus/kegiatan.', 'sanksi_default' => 'Skorsing dan pelaporan ke pihak berwenang kampus.'],
            ['nama' => 'Mengonsumsi atau membawa narkoba', 'kategori' => 'berat', 'deskripsi' => 'Membawa, menggunakan, atau mengedarkan narkoba/psikotropika.', 'sanksi_default' => 'Pemberhentian keanggotaan dan pelaporan ke pihak berwenang.'],
            ['nama' => 'Intimidasi atau perundungan', 'kategori' => 'berat', 'deskripsi' => 'Melakukan intimidasi, ancaman, atau perundungan kepada anggota lain.', 'sanksi_default' => 'Investigasi etik, skorsing, dan pendampingan korban.'],
            ['nama' => 'Pelecehan verbal', 'kategori' => 'berat', 'deskripsi' => 'Pelecehan secara verbal atau isyarat yang menyinggung.', 'sanksi_default' => 'Skorsing dan rujukan ke tim etik/PKM.'],
            ['nama' => 'Pelecehan fisik/non-verbal', 'kategori' => 'berat', 'deskripsi' => 'Pelecehan fisik atau tindakan non-verbal yang melanggar batasan personal.', 'sanksi_default' => 'Skorsing dan proses disiplin sesuai aturan kampus.'],
            ['nama' => 'Penyalahgunaan dana organisasi', 'kategori' => 'berat', 'deskripsi' => 'Menggunakan dana/anggaran organisasi tanpa izin atau untuk kepentingan pribadi.', 'sanksi_default' => 'Pengembalian dana, skorsing, dan audit internal.'],
            ['nama' => 'Menghilangkan aset inventaris', 'kategori' => 'berat', 'deskripsi' => 'Hilangnya aset/inventaris karena kelalaian berat atau sengaja.', 'sanksi_default' => 'Ganti rugi dan pencabutan hak kepanitiaan.'],
            ['nama' => 'Penyalahgunaan akses sistem', 'kategori' => 'berat', 'deskripsi' => 'Menyalahgunakan akses aplikasi/sistem informasi organisasi.', 'sanksi_default' => 'Pencabutan akses dan investigasi keamanan.'],
            ['nama' => 'Kegiatan politik praktis tanpa izin', 'kategori' => 'sedang', 'deskripsi' => 'Membawa atribut/agenda politik praktis ke kegiatan tanpa persetujuan.', 'sanksi_default' => 'Peringatan tertulis dan penghentian kegiatan.'],
            ['nama' => 'Membawa senjata tajam/tumpul', 'kategori' => 'berat', 'deskripsi' => 'Membawa senjata tajam/tumpul ke lingkungan kampus tanpa alasan sah.', 'sanksi_default' => 'Skorsing dan pelaporan ke keamanan kampus.'],
            ['nama' => 'Tindakan asusila di lingkungan kampus', 'kategori' => 'berat', 'deskripsi' => 'Melakukan tindakan asusila di area kampus/kegiatan resmi.', 'sanksi_default' => 'Sanksi berat sesuai kode etik kampus dan pendampingan.'],
        ];

        foreach ($items as $item) {
            PelanggaranMaster::updateOrCreate(
                ['nama' => $item['nama']],
                [
                    'kategori' => $item['kategori'],
                    'deskripsi' => $item['deskripsi'],
                    'sanksi_default' => $item['sanksi_default'],
                ]
            );
        }
    }
}
