<?php
require_once("tfpdf/tfpdf.php");

class ContactInfo {
    function __construct(
        public string $companyName,
        public string $registrationNo,
        public string $CIF,
        public string $address,
        public string|null $bank,
        public string|null $IBAN,
        public string $phone,
        public string $email,
        public string $site
    ) {}
}

class InvoiceItem {
    function __construct(
        public string $description,
        public string $UM,
        public int $amount,
        public int $unitPrice,
        public int $totalNoTax,
        public int $tax,
        public int $taxUnit,
        public int $totalWTax
    ) {}
}

function formatCurrency(int $amount, int $decimalPlaces = 2): string {
    $divisor = 10 ** $decimalPlaces;
    $whole = intdiv($amount, $divisor);
    $decimal = $amount % $divisor;
    $whole = number_format($whole, 0, "", ".");
    return $whole . "," . str_pad($decimal, $decimalPlaces, "0", STR_PAD_LEFT);
}

class InvoicePDF extends tFPDF {
    const HeadingColor = [47, 140, 158];
    protected ContactInfo $sellerInfo;
    protected ContactInfo $buyerInfo;
    protected string $image;
    protected string $invoiceNo;
    protected DateTimeImmutable $issuedDate;
    protected DateTimeImmutable $deadline;
    protected int $paymentTotal;
    const infoKeyTranslation = array(
        "companyName" => "--- NEVER PRINTED ---",
        "registrationNo" => "Nr. ord. reg. com. / an",
        "CIF" => "CIF",
        "address" => "Adresa",
        "bank" => "Banca",
        "IBAN" => "IBAN",
        "phone" => "Telefon",
        "email" => "Email",
        "site" => "Site"
    );
    function setInvoiceData(ContactInfo $sellerInfo, ContactInfo $buyerInfo, string $invoiceNo, DateTimeImmutable $issuedDate, DateTimeImmutable $deadline, string $image, int $paymentTotal) {
        $this->sellerInfo = $sellerInfo;
        $this->buyerInfo = $buyerInfo;
        $this->invoiceNo = $invoiceNo;
        $this->issuedDate = $issuedDate;
        $this->deadline = $deadline;
        $this->image = $image;
        $this->paymentTotal = $paymentTotal;
    }
    function Header(): void {
        $this->FancyContactInfo($this->sellerInfo, true);
        $this->Ln();
        $this->Image($this->image, 140, 15, 332 / 5.8, 168 / 5.8);
        $this->SetDrawColor(...self::HeadingColor);
        $this->Ln();
        $x = $this->GetX();
        $y = $this->GetY();
        $this->Line($x, $y, $x + 190, $y);
        $this->Ln();
    }
    function Footer(): void {
        $this->SetXY(10, -30);
        $this->SetDrawColor(...self::HeadingColor);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->SetY(-28);
        $this->SetFont("sans-serif", "", 8);
        $this->Write(3, $this->sellerInfo->companyName);
        $this->Ln();
        $s = $this->sellerInfo;
        $wp = function(string $key, string $val) {
            $this->WriteProperty(3.5, $key, $val, "sans-serif", 8, false, "");
        };
        $wp("registrationNo", $s->registrationNo);
        $wp("CIF", $s->CIF);
        $this->SetXY(10, -28);
        $this->SetLeftMargin(80);
        $wp("address", $s->address);
        $wp("phone", $s->phone);
        $this->SetXY(10, -28);
        $this->SetLeftMargin(150);
        $wp("email", $s->email);
        $wp("site", $s->site);
        $this->SetXY(10, -17);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->SetXY(10, -14);
        $this->SetTextColor(205, 205, 205);
        $this->Write(3, "creat prin factureaza.ro");
    }
    function FancyContactInfo(ContactInfo $info, bool $isSeller): void {
        $data = get_object_vars($info);
        foreach($data as $key => $val) {
            if(is_null($val)) {
                continue;
            }
            if($key == "companyName") {
                if($isSeller) {
                    $this->SetFont("sans-serif", "", 18);
                    $this->SetTextColor(...self::HeadingColor);
                    $this->Write(10, $val);
                    $this->Ln();
                } else {
                    $this->SetFont("sans-serif", "B", 10);
                    $this->SetTextColor(0, 0, 0);
                    $this->Write(10, "Cumpărător:");
                    $this->Ln(7);
                    $this->SetTextColor(...self::HeadingColor);
                    $this->SetFont("sans-serif", "", 14);
                    $this->Write(8, $val);
                    $this->Ln(7);
                }
            } else {
                $this->WriteProperty(4, $key, $val, "sans-serif", 10, $key == "site");
            }
        }
    }
    function WriteProperty(float $h, string $key, string $val, string $font, float $size, bool $linkify, string $otherStyles = "B"): void {
        if(array_key_exists($key, self::infoKeyTranslation)) {
            $key = self::infoKeyTranslation[$key];            
        }
        $this->SetFont($font, "", $size);
        $this->SetTextColor(0, 0, 0);
        $this->Write($h, $key . ": ");
        if($linkify) {
            $this->SetFont("", "U" . $otherStyles);
            $this->Write($h, $val, $val);
        } else {
            $this->SetFont("", $otherStyles);
            $this->Write($h, $val);
        }
        $this->Ln();
    }
    function MainBodyBeginning(): void {
        $x = $this->GetX();
        $y = $this->GetY();
        $this->Ln(8);
        $this->SetTextColor(...self::HeadingColor);
        $this->SetFont("sans-serif", "", 16);
        $this->Write(10, "FACTURĂ");
        $this->Ln();
        $this->SetTextColor(0, 0, 0);
        $h = 4;
        $s = 11;
        $this->WriteProperty($h, "Seria și numărul facturii", $this->invoiceNo, "sans-serif", $s, false);
        $this->WriteProperty($h, "Data facturii (zi.luna.an)", $this->issuedDate->format("d.m.Y"), "sans-serif", $s, false);
        $this->WriteProperty($h, "Termed de plată (zi.luna.an)", $this->deadline->format("d.m.Y"), "sans-serif", $s, false);
        $this->Image("rounded.png", $this->GetX() + 1, $this->GetY() + 1, 1612 / 27.5, 179 / 27.5);
        $this->SetXY($this->GetX() + 6, $this->GetY() + 1.5);
        $this->SetTextColor(...self::HeadingColor);
        $this->SetFont("sans-serif", "", 9);
        $this->Write(5, "Plătește online (" . formatCurrency($this->paymentTotal) . " RON)", "https://www.example.com");
        $this->SetXY($x, $y);
        $this->SetLeftMargin(120);
        $this->FancyContactInfo($this->buyerInfo, false);
        $this->SetLeftMargin(10);
        $this->Ln();
    }

    /**
     * @param string[] $text
     * @param float[] $widths
     * @param string[] $cellAlignments
     */
    function SingleRow(array $text, array $widths, float $height, array $cellAlignments, bool $bottomEdge = false, float $marginTop = 0.5): void {
        assert(count($text) == count($widths) && count($text) == count($cellAlignments));
        $x = $this->GetX();
        $origX = $x;
        $y = $this->GetY();
        $newY = $y + $height + $marginTop;
        $this->Line($x, $y, $x, $newY);
        for($i = 0; $i < count($text); $i++) {
            $this->SetXY($x, $y + $marginTop);
            $this->MultiCell($widths[$i], 3, $text[$i], 0, $cellAlignments[$i]);
            $newX = $x + $widths[$i];
            $this->SetXY($newX, $y);
            $this->Line($x, $y, $newX, $y);
            $this->Line($newX, $y, $newX, $newY);
            $x = $newX;
        }
        $this->SetXY($origX, $newY);
        if($bottomEdge) {
            $this->Line($origX, $newY, $x, $newY);
        }
    }

    /**
     * @param InvoiceItem[] $items
     * @param float[] $widths
     * @param float[] $heights
     * @param string[] $cellAlignments
     */
    function TableRows(array $items, array $widths, array $heights, array $cellAlignments): void {
        assert(count($heights) == count($items));
        for($i = 0; $i < count($items); $i++) {
            $formattedItemData = array(
                $i + 1,
                $items[$i]->description,
                $items[$i]->UM,
                $items[$i]->amount,
                formatCurrency($items[$i]->unitPrice),
                formatCurrency($items[$i]->totalNoTax),
                formatCurrency($items[$i]->tax, 1),
                formatCurrency($items[$i]->taxUnit, 1),
                formatCurrency($items[$i]->totalWTax)
            );
            $this->SingleRow($formattedItemData, $widths, $heights[$i], $cellAlignments);
        }
    }
    function _putinfo() {
        // Override "CreationDate" to be the issue date so that the PDF is deterministic.
        $this->CreationDate = $this->issuedDate->getTimestamp();
        parent::_putinfo();
    }
}

$cubusInfo = new ContactInfo(
    "S.C. Cubus Arts S.R.L.",
    "J32/508/2000",
    "RO 13548146",
    "Strada Morii 198\n"
    .
    "892200 Lugojoara, jud. Timiș, România",
    null,
    null,
    "0368 409 233",
    "office@factureaza.ro",
    "www.cubus.ro"
);

$impexInfo = new ContactInfo(
    "S.C. DEMO IMPEX S.R.L.",
    "132/500/2000",
    "RO 14468355",
    "Bdul. Triumfului nr. 4 ap. 2\n"
    .
    "589100 Sibiu, jud. Sibiu, România",
    "Banca Comerciala Sibiu",
    "RO56 RZBR 0000 0600 0329 1177",
    "+40 123 789456",
    "office@factureaza.ro",
    "www.factureaza.ro"
);

$invoiceItems = array(
    new InvoiceItem(
        "Prestări servicii programare cf. ctc. 3482/27.10.2023",
        "ore",
        86,
        185_00,
        15_910_00,
        19_0,
        3_022_90,
        18_932_90
    ),
    new InvoiceItem(
        "Servicii suport cf. ctc. 342/06.11.2023",
        "ore",
        4,
        70_00,
        280_00,
        19_0,
        53_20,
        333_20
    ),
    new InvoiceItem(
        "Domeniu demo-impex.ro",
        "ore",
        1,
        120_00,
        120_00,
        19_0,
        22_80,
        142_80
    )
);

$sumTotal = 0;
$sumTax = 0;
$sumWithoutTax = 0;
$avgTax = 19_0;
foreach($invoiceItems as $item) {
    $sumTotal += $item->totalWTax;
    $sumTax += $item->totalWTax - $item->totalNoTax;
    $sumWithoutTax += $item->totalNoTax;
    assert($item->tax == $avgTax);
}

$message = "Sperăm intr-o colaborare fructuoasă şi pe viitor." .
            "\n" .
            "Cu stimă maximă și virtute absolută, Ion Pop S.C. DEMO IMPEX S.R.L.";

$header = ["Nr.\ncrt", "Denumirea produselor sau a\nserviciilor", "U.M.", "Cant.", "Preț unitar\n(fără TVA)\n--RON--", "Valoarea\n(fără TVA)\n--RON--", "Cota\nTVA", "Valoare TVA\n--RON--", "Valoare Totală\n--RON--"];
$headerAlignments = array_fill(0, count($header), "C");
$tableWidths = [8, 50, 13, 13, 22, 20, 17, 22, 27];
$tableHeights = [6.5, 6.5, 20];
$tableAlignments = ["L", "L", "L", "R", "R", "R", "R", "R", "R"];

$subtotalWidths = array_merge([array_sum(array_slice($tableWidths, 0, 5))],  array_slice($tableWidths, -4));
$totalWidths = [array_sum(array_slice($tableWidths, 0, 5)), array_sum(array_slice($tableWidths, -4))];
$subtotalText = [
    "Subtotaluri -RON-",
    formatCurrency($sumWithoutTax),
    formatCurrency($avgTax, 1),
    formatCurrency($sumTax),
    formatCurrency($sumTotal)
];
$subtotalAlignments = ["C", "R", "R", "R", "R"];
$totalText = [
    "Valoare totală de plată factura curentă - incl. TVA -RON-",
    formatCurrency($sumTotal)
];
$totalAlignments = ["C", "R"];

$pdf = new InvoicePDF();
$pdf->AddFont("sans-serif", "", "DejaVuSans.ttf", true);
$pdf->AddFont("sans-serif", "B", "DejaVuSans-Bold.ttf", true);
$pdf->AddFont("sans-serif", "I", "DejaVuSans-Oblique.ttf", true);
$pdf->AddFont("monospace", "", "DejaVuSansMono.ttf", true);
$pdf->AddFont("monospace", "B", "DejaVuSansMono-Bold.ttf", true);
$pdf->setInvoiceData(
    $cubusInfo,
    $impexInfo,
    "SRV-1192",
    new DateTimeImmutable("2023-11-26"),
    new DateTimeImmutable("2023-12-11"),
    "logo-cubus.png",
    $sumTotal
);
$pdf->AddPage();
$pdf->MainBodyBeginning();
$pdf->SetFont("monospace", "", 8);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetDrawColor(117, 209, 209);
$pdf->SingleRow($header, $tableWidths, 17, $headerAlignments);
$pdf->SetFont("monospace", "B", 8);
$pdf->TableRows($invoiceItems, $tableWidths, $tableHeights, $tableAlignments);
$pdf->SingleRow($subtotalText, $subtotalWidths, 3.2, $subtotalAlignments);
$pdf->SingleRow($totalText, $totalWidths, 3.2, $totalAlignments, true);
$pdf->Ln(20);
$pdf->SetFont("sans-serif", "I", 8);
$pdf->Write(4, $message);
$dest = "";
$name = "invoice.pdf";
if(php_sapi_name() == "cli" && isset($argv[1])) {
    $dest = "F";
    $name = $argv[1];
}
$pdf->Output($dest, $name, true);
