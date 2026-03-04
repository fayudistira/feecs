<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTermsConditionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'language' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('language');
        $this->forge->createTable('terms_conditions');

        // Insert default terms for each language
        $db = \Config\Database::connect();
        $termsData = [
            [
                'language' => 'Mandarin',
                'title' => 'Syarat dan Ketentuan',
                'content' => file_get_contents(ROOTPATH . 'public/templates/terms.txt') ?: $this->getDefaultMandarinTerms(),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'language' => 'English',
                'title' => 'Terms and Conditions',
                'content' => $this->getDefaultEnglishTerms(),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'language' => 'Japanese',
                'title' => '利用規約',
                'content' => $this->getDefaultJapaneseTerms(),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'language' => 'Korean',
                'title' => '이용약관',
                'content' => $this->getDefaultKoreanTerms(),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'language' => 'German',
                'title' => 'AGB - Allgemeine Geschäftsbedingungen',
                'content' => $this->getDefaultGermanTerms(),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $db->table('terms_conditions')->insertBatch($termsData);
    }

    public function down()
    {
        $this->forge->dropTable('terms_conditions');
    }

    private function getDefaultMandarinTerms()
    {
        return <<<EOT
<!-- Terms Modal -->
<h3>1. Pendaftaran</h3>
<p>
    Pendaftaran kursus di Xihuan Mandarin Indonesia bersifat online
    melalui formulir pendaftaran yang tersedia. Calon siswa wajib
    mengisi formulir dengan data yang benar dan lengkap.
</p>
<hr />
<h3>2. Pembayaran</h3>
<ul>
    <li>
        Pembayaran biaya pendaftaran harus dilakukan setelah mengisi
        formulir pendaftaran.
    </li>
    <li>
        Pembayaran dapat dilakukan melalui transfer bank ke rekening yang
        telah ditentukan.
    </li>
    <li>
        Bukti pembayaran <strong>WAJIB</strong> dikirimkan melalui
        WhatsApp kepada admin.
    </li>
    <li>
        Admin akan memberikan Kuitansi Pembayaran setelah pembayaran
        <strong>Terkonfirmasi</strong> dan dianggap sah.
    </li>
    <li>
        Pembayaran tidak dapat dikembalikan (non-refundable) dengan alasan
        apapun.
    </li>
</ul>
<hr />
<h3>3. Ketentuan Pelaksanaan</h3>
<ul>
    <li>
        Kursus dimulai setiap tanggal 10 setiap bulan sepanjang tahun.
        Jika pada tanggal tersebut jatuh pada hari Sabtu, Minggu, atau
        Hari Libur maka akan dimajuan/disesuaikan.
    </li>
    <li>
        Khusus bagi Anda yang melakukan request untuk kursus di Luar
        Periode tanggal 10 silahkan menghubungi admin kami.
    </li>
    <li>
        Bagi siswa yg ingin melakukan garansi (mengulang kelas) tidak
        dikenakan biaya apapun kecuali biaya asrama per bulan 500k
    </li>
</ul>
<hr />
<h3>4. Ketentuan Pembatalan dan Perubahan Program</h3>
<h4>4.A. PEMBATALAN KURSUS:</h4>
<ul>
    <li>
        Konfirmasi Pembatalan Kursus wajib disampaikan maksimal 5 HARI
        sebelum pelaksanaan tanggal kursus.
    </li>
    <li>
        Konsekuensi dari pembatalan adalah biaya pendaftaran hangus.
    </li>
    <li>
        Pengembalian biaya (Refund) hanya dapat dilakukan apabila
        pembelajaran belum dimulai/dilaksanakan.
    </li>
</ul>
<hr />
<h3>5. Privasi Data</h3>
<p>
    Data pribadi siswa akan dijaga kerahasiaannya dan hanya digunakan
    untuk keperluan administrasi internal.
</p>
<hr />
<h3>6. Lain-lain</h3>
<ul>
    <li>
        Kami berhak mengubah syarat dan ketentuan sewaktu-waktu dengan
        memberitahukan terlebih dahulu.
    </li>
</ul>
EOT;
    }

    private function getDefaultEnglishTerms()
    {
        return <<<EOT
<h3>1. Registration</h3>
<p>
    Course registration at our institution is done online through the
    registration form available. Prospective students must fill out the
    form with correct and complete data.
</p>
<hr />
<h3>2. Payment</h3>
<ul>
    <li>
        Registration fee payment must be made after completing the
        registration form.
    </li>
    <li>
        Payment can be made via bank transfer to the designated account.
    </li>
    <li>
        Payment proof <strong>MUST</strong> be sent via WhatsApp to admin.
    </li>
    <li>
        Admin will provide a Payment Receipt after payment is
        <strong>Confirmed</strong> and considered valid.
    </li>
    <li>
        Payments are non-refundable for any reason.
    </li>
</ul>
<hr />
<h3>3. Implementation Terms</h3>
<ul>
    <li>
        Courses start on the 10th of every month throughout the year.
        If that date falls on Saturday, Sunday, or Holiday, it will be
        adjusted to the next business day.
    </li>
    <li>
        For requests outside the 10th period, please contact our admin.
    </li>
    <li>
        Students who want to repeat the class (warranty) are not charged
        any fee except for dormitory costs of 500k per month.
    </li>
</ul>
<hr />
<h3>4. Cancellation and Program Change Terms</h3>
<h4>4.A. COURSE CANCELLATION:</h4>
<ul>
    <li>
        Course cancellation must be submitted at least 5 DAYS before
        the course start date.
    </li>
    <li>
        Cancellation will result in forfeiture of the registration fee.
    </li>
    <li>
        Refunds can only be made if the course has not started.
    </li>
</ul>
<hr />
<h3>5. Data Privacy</h3>
<p>
    Student personal data will be kept confidential and only used for
    internal administrative purposes.
</p>
<hr />
<h3>6. Miscellaneous</h3>
<ul>
    <li>
        We reserve the right to modify terms and conditions at any time
        with prior notice.
    </li>
</ul>
EOT;
    }

    private function getDefaultJapaneseTerms()
    {
        return <<<EOT
<h3>1. お申込み</h3>
<p>
    当校へのコースお申し込みは、ウェブサイト上の申込みフォームより
    お願いします。受講者は正確かつ完全な情報でお申込みフォームに
    記入してください。
</p>
<hr />
<h3>2. お支払い</h3>
<ul>
    <li>
        お申込み完了後にお支払いをお願いします。
    </li>
    <li>
        お支払いは指定銀行口座への振込となります。
    </li>
    <li>
        お支払い証拠をマネージャーへWhatsAppで送ってください。
    </li>
    <li>
        お支払いが確認次第、領収書を発行いたします。
    </li>
    <li>
        いかなる理由においても返金致しません。
    </li>
</ul>
<hr />
<h3>3. 規定</h3>
<ul>
    <li>
        コースは以下の毎月10日から開始します。
        10日が土曜日、日曜日、祝日の場合は翌平日となります。
    </li>
    <li>
        10日以外の日程をご希望の場合はマネージャーまで
        お問い合わせしてください。
    </li>
    <li>
        クラスの再受講（保証）をご希望の場合、
        宿舎費月額50万ルを除き無料です。
    </li>
</ul>
<hr />
<h3>4. キャンセル・コース変更規定</h3>
<h4>4.A. コースキャンセル:</h4>
<ul>
    <li>
        キャンセルはコース開始の5日前までに
        お伝えください。
    </li>
    <li>
        キャンセルされた場合、お申込み費用は返金致しません。
    </li>
    <li>
        コース開始前の場合は返金対応いたします。
    </li>
</ul>
<hr />
<h3>5. プライバシー</h3>
<p>
    生徒様の个人信息は、当校の 管理目的のみに使用され、
    機密として保持されます。
</p>
<hr />
<h3>6. その他</h3>
<ul>
    <li>
        当校は事前に告知した上で、
        利用規約を変更する権利を有します。
    </li>
</ul>
EOT;
    }

    private function getDefaultKoreanTerms()
    {
        return <<<EOT
<h3>1. 등록</h3>
<p>
    당 기관의 과정 등록은 이용 가능한 등록 양식을 통해
    온라인으로 진행됩니다. 지원자는 정확하고 완전한 정보로
    등록 양식을 작성해야 합니다.
</p>
<hr />
<h3>2. 결제</h3>
<ul>
    <li>
        등록비는 등록 양식 작성 후 지불해야 합니다.
    </li>
    <li>
        지정된 은행 계좌로 은행 송금을 통해 결제가 가능합니다.
    </li>
    <li>
        결제 증빙서류는 반드시 WhasApp으로 관리자에게
        전송해야 합니다.
    </li>
    <li>
        결제가 확인되면 관리자가 결제 영수증을 제공합니다.
    </li>
    <li>
        어떤 이유든 환불이 불가능합니다.
    </li>
</ul>
<hr />
<h3>3. 운영 규정</h3>
<ul>
    <li>
        과정은 매년 매월 10일에 시작됩니다.
        해당 날짜가 토, 일, 공휴일인 경우 다음 영업일로
        조정됩니다.
    </li>
    <li>
        10일以外的 기간에 과정을 원하시면 관리자에게
        문의해 주세요.
    </li>
    <li>
        보증을 위한 클래스 재수강은 월 숙박비 50만름을
        제외하고 무료입니다.
    </li>
</ul>
<hr />
<h3>4. 취소 및 프로그램 변경 규정</h3>
<h4>4.A. 과정 취소:</h4>
<ul>
    <li>
        과정 시작 최소 5일 전에 취소 통보를 해야 합니다.
    </li>
    <li>
        취소 시 등록비는 환불되지 않습니다.
    </li>
    <li>
        과정이 시작되지 않은 경우에만 환불이 가능합니다.
    </li>
</ul>
<hr />
<h3>5. 개인정보 보호</h3>
<p>
    학생의 개인정보는 기밀 유지되며 내부 관리 목적으로만
    사용됩니다.
</p>
<hr />
<h3>6. 기타</h3>
<ul>
    <li>
        당 기관은 사전 통보 후 약관을 수정할 권리가
        있습니다.
    </li>
</ul>
EOT;
    }

    private function getDefaultGermanTerms()
    {
        return <<<EOT
<h3>1. Anmeldung</h3>
<p>
    Die Kursanmeldung an unserer Institution erfolgt online über das
    verfügbare Anmeldeformular. Interessenten müssen das Formular mit
    korrekten und vollständigen Daten ausfüllen.
</p>
<hr />
<h3>2. Zahlung</h3>
<ul>
    <li>
        Die Anmeldegebühr muss nach Ausfüllen des Anmeldeformulars
        gezahlt werden.
    </li>
    <li>
        Die Zahlung kann per Banküberweisung auf das angegebene Konto
        erfolgen.
    </li>
    <li>
        Zahlungsnachweis <strong>MUSS</strong> per WhatsApp an den
        Administrator gesendet werden.
    </li>
    <li>
        Der Administrator stellt nach Bestätigung der Zahlung eine
        Quittung aus.
    </li>
    <li>
        Zahlungen werden aus keinem Grund erstattet.
    </li>
</ul>
<hr />
<h3>3. Durchführungsbestimmungen</h3>
<ul>
    <li>
        Die Kurse beginnen am 10. jedes Monats throughout the year.
        Wenn dieses Datum auf einen Samstag, Sonntag oder Feiertag
        fällt, wird es auf den nächsten Werktag verschoben.
    </li>
    <li>
        Für Anfragen außerhalb des 10. Zeitraums wenden Sie sich bitte
        an unseren Administrator.
    </li>
    <li>
        Schüler, die den Kurs wiederholen möchten (Garantie), werden
        nicht berechnet, außer für Unterkunftskosten von 500k pro Monat.
    </li>
</ul>
<hr />
<h3>4. Stornierungs- und Programmänderungsbedingungen</h3>
<h4>4.A. KURSSTORNIERUNG:</h4>
<ul>
    <li>
        Die Stornierung muss mindestens 5 TAGE vor Kursbeginn
        mitgeteilt werden.
    </li>
    <li>
        Bei Stornierung verfällt die Anmeldegebühr.
    </li>
    <li>
        Eine Rückerstattung ist nur möglich, wenn der Kurs noch nicht
        begonnen hat.
    </li>
</ul>
<hr />
<h3>5. Datenschutz</h3>
<p>
    Die persönlichen Daten der Schüler werden vertraulich behandelt und
    nur für interne Verwaltungszwecke verwendet.
</p>
<hr />
<h3>6. Sonstiges</h3>
<ul>
    <li>
        Wir behalten uns das Recht vor, die Bedingungen jederzeit mit
        vorheriger Ankündigung zu ändern.
    </li>
</ul>
EOT;
    }
}
