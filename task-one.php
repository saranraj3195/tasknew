<?php

$xmlData = 
<<<XML
<VehAvail>
<VehAvailCore Status="Available">
<Vehicle AirConditionInd="true" TransmissionType="Automatic" FuelType="Unspecified" DriveType="Unspecified" PassengerQuantity="5" BaggageQuantity="3" Code="SCAR" CodeContext="CARTRAWLER">
<VehType VehicleCategory="1" DoorCount="2"/>
<VehClass Size="7"/>
<VehMakeModel Name="Volkswagen Jetta or similar" Code="SCAR"/>
<PictureURL>https://ctimg-fleet.cartrawler.com/volkswagen/jetta/primary.png</PictureURL>
<VehIdentity VehicleAssetNumber="26537"/>
</Vehicle>
<RentalRate>
<VehicleCharges>
<VehicleCharge Description="Unlimited mileage" TaxInclusive="true" IncludedInRate="true" Purpose="609.VCP.X"/>
</VehicleCharges>
<RateQualifier RateQualifier="PREPAID-IN" PromotionCode="INCLUSIVE_NO_EXCESS"/>
</RentalRate>
<TotalCharge RateTotalAmount="127.85" EstimatedTotalAmount="127.85" CurrencyCode="USD"/>
<PricedEquips>
<PricedEquip>
<Equipment EquipType="13">
<Description>GPS</Description>
</Equipment>
<Charge Amount="16.99" CurrencyCode="USD" TaxInclusive="false" IncludedInRate="false"/>
</PricedEquip>
<PricedEquip>
<Equipment EquipType="8">
<Description>Child toddler seat</Description>
</Equipment>
<Charge Amount="13.99" CurrencyCode="USD" TaxInclusive="false" IncludedInRate="false"/>
</PricedEquip>
<PricedEquip>
<Equipment EquipType="9">
<Description>Booster seat</Description>
</Equipment>
<Charge Amount="13.99" CurrencyCode="USD" TaxInclusive="false" IncludedInRate="false"/>
</PricedEquip>
<PricedEquip>
<Equipment EquipType="7">
<Description>Infant child seat</Description>
</Equipment>
<Charge Amount="13.99" CurrencyCode="USD" TaxInclusive="false" IncludedInRate="false"/>
</PricedEquip>
<PricedEquip>
<Equipment EquipType="4">
<Description>Ski rack</Description>
</Equipment>
<Charge Amount="18.00" CurrencyCode="USD" TaxInclusive="true" IncludedInRate="false"/>
</PricedEquip>
</PricedEquips>
<Fees>
<Fee Amount="127.85" CurrencyCode="USD" Purpose="22"/>
<Fee Amount="0.00" CurrencyCode="USD" Purpose="23"/>
<Fee Amount="0.00" CurrencyCode="USD" Purpose="6"/>
</Fees>
<Reference Type="16" ID="846174189" ID_Context="CARTRAWLER" DateTime="2021-06-14T06:27:28.549+01:00" URL="72cc9427-c597-4545-a6e0-ac48d0b97886.64"/>
<TPA_Extensions>
<PictureURLHD>https://ctimg-fleet.cartrawler.com/volkswagen/jetta/primary.png</PictureURLHD>
<UpSell Insurance="0"/>
<DebitCard OnArrival="true"/>
<PPDep Available="false" Keep="false"/>
<ZeroDeposit Available="false"/>
<FuelPolicy Type="FULLFULL" Description="Fuel: Pick up and return full."/>
<Config OrderBy="7" Relevance="0" Preferred="0" Insurance="false" Duration="1" Limited="1" CC_Info="true" PhysicalInetAddress="-1762762070" ConsumerAddress="2001849194" HotelDelivery="false"/>
<OrderBy Index="7"/>
<Indexation>
<IndexByPrice Key="6" BundleText="Standard" BundleType="Rate_IN_INCLUSIVE_NO_EXCESS"/>
</Indexation>
<CC_Info Required="true"/>
<SpecialOffers>
<Offer Type="pre_registration" UIToken="pre_registration" ShortText="Pre-Registration available" Index="0" SEFree="1">For faster, easier car hire, add driver details before pick-up.</Offer>
<Offer Type="sanitized_car" UIToken="sanitized_car" ShortText="Sanitised car" Index="999" SEFree="1">This car hire brand has committed to maintaining sanitisation measures as per WHO COVID-19 guidelines.</Offer>
</SpecialOffers>
<Duration Days="1"/>
<PricedEquipsDisplay>
<PricedEquip EquipType="13" Amount="16.99" CurrencyCode="USD" RateType="POSTPAID"/>
<PricedEquip EquipType="8" Amount="13.99" CurrencyCode="USD" RateType="POSTPAID"/>
<PricedEquip EquipType="9" Amount="13.99" CurrencyCode="USD" RateType="POSTPAID"/>
<PricedEquip EquipType="7" Amount="13.99" CurrencyCode="USD" RateType="POSTPAID"/>
<PricedEquip EquipType="4" Amount="18.00" CurrencyCode="USD" RateType="POSTPAID"/>
</PricedEquipsDisplay>
<Fleet>
<FleetGroup>
<Vehicle AirConditionInd="true" TransmissionType="Automatic" FuelType="Unspecified" DriveType="Unspecified" PassengerQuantity="5" BaggageQuantity="3" Code="SCAR" CodeContext="CARTRAWLER">
<VehType VehicleCategory="1" DoorCount="2"/>
<VehClass Size="7"/>
<VehMakeModel Name="Volkswagen Jetta or similar" Code="SCAR"/>
<PictureURL>https://ctimg-fleet.cartrawler.com/volkswagen/jetta/primary.png</PictureURL>
<VehIdentity VehicleAssetNumber="26537"/>
</Vehicle>
</FleetGroup>
</Fleet>
</TPA_Extensions>
</VehAvailCore>
<VehAvailInfo>
<PricedCoverages>
<PricedCoverage>
<Coverage CoverageType="601.VCT.X"/>
<Charge Description="Extra insurance" TaxInclusive="true" IncludedInRate="true"/>
</PricedCoverage>
</PricedCoverages>
</VehAvailInfo>
</VehAvail>

XML;

$xml = simplexml_load_string($xmlData);

$host = 'localhost';
$dbname = 'task-one';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$stmt = $pdo->prepare("INSERT INTO veh_avail (status, vehicle_model, rate_total_amount, currency_code) VALUES (?, ?, ?, ?)");

foreach ($xml->VehAvail as $vehAvail) {
    $status = (string) $vehAvail->VehAvailCore['Status'];
    $vehicleModel = (string) $vehAvail->VehAvailCore->Vehicle->VehMakeModel['Name'];
    $rateTotalAmount = (float) $vehAvail->VehAvailCore->TotalCharge['RateTotalAmount'];
    $currencyCode = (string) $vehAvail->VehAvailCore->TotalCharge['CurrencyCode'];

    $stmt->execute([$status, $vehicleModel, $rateTotalAmount, $currencyCode]);
}

$stmt = $conn->query("SELECT * FROM veh_avail");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<table>";
foreach ($data as $result) {
    echo "<tr>";
    echo "<td> Status </td>";
    
    echo "<td> Vehicle Model </td>";
    echo "<td>Rate Total Amount</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>" . $result['status'] . "</td>";
    
    echo "<td>" .$result['vehicle_model'] . "</td>";
    echo "<td>" .$result['rate_total_amount'] . ' ' . $result['currency_code'] . "</td>";
    echo "</tr>";
}
echo "</table>";

?>