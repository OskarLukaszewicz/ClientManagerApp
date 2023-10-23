<div>
  <h1><b> Dodaj Klienta</b> </h1>
  <div>
    <form class="createForm" action ="./?entity=Client&action=create" method="post">
      <ul>
        <div class="row">
          <div class="p-2 formContainer col">
            <h5><b>Dane klienta:</b></h5>
            
              <label for="clientName"> <b>Nazwa Klienta:</b></label><br>
              <input required id="clientName" type="text" name="client_name" /><br>
            
              <label for="NIP"><b>NIP:</b></label><br>
              <input required id="NIP" type="text" name="NIP" /><br>
            
              <label for="country"><b>Kraj:</b></label><br>
              <input required id="country" type="text" name="country" /><br>

              <label for="city"><b>Miasto:</b></label><br>
              <input required id="city" type="text" name="city" /><br>
            
              <label for="adress" ><b>Adres:</b></label><br>
              <input required id="adress" type="text" name="address" /><br>
            
          </div>
          <div class="p-2 formContainer col">
            <h5><b>Osoba kontaktowa:</b></h5>
            
              <label for="contactName"><b>Imię:</b></label> <br>
              <input required id="contactName" type="text" name="first_name" /><br>
            
              <label for="contactSurname"><b>Nazwisko:</b></label><br>
              <input required id="contactSurname" type="text" name="last_name" /><br>
            
              <label for="email"><b>Email:</b></label><br>
              <input required id="email" type="email" name="email" /><br>
            
              <label for="phoneNumber"><b>Nr telefonu:</b></label><br>
              <input required id="phoneNumber" type="text" name="phone_number" /><br>
            
          </div>
          <div class="p-2 formContainer col">
            <h5><b>Pakiet:</b></h5>
            
            <label for="packageTypes"><b>Rodzaj pakietu:</b></label><br>
            <select required id="packageTypes" name="package_type_id">
              <option value="1">Basic</option>
              <option value="2">Premium</option>
              <option value="3">SuperPremium</option>
            </select> <br>
            <input class="btn btn-success my-2 py-1" type="submit" value="Wyślij" />
            
          </div>
        </div>
      </ul>
    </form>
  </div>
</div>