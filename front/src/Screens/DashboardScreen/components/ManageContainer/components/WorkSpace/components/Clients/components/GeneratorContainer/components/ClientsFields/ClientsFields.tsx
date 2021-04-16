import * as React from 'react';
import './index.scss';
import Address from './components/Address';
import Citizenship from './components/Citizenship';
import Contacts from './components/Contacts';
import Fio from './components/Fio';
import Passport from './components/Passport';
import Statement from './components/Statement';
import PowerOfAttorney from './components/PowerOfAttorney';
import { useClientsFields } from './useClientsFields';

const ClientsFields = () => {
  const meta = useClientsFields();

  return (
    <main className="clients">
      <Fio initialData={meta.fioData} id={meta.personId} />
      <Contacts initialData={meta.contacts} id={meta.personId} />
      <Citizenship initialData={meta.citizenship} id={meta.personId} />
      <Passport initialData={meta.passport} id={meta.personId} />
      <Address initialData={meta.address} id={meta.personId} />

      {meta.userType === 'client' && (
        <>
          <Statement
            initialData={meta.consents}
            clientId={meta.clientId}
            personId={meta.personId}
          />
          <PowerOfAttorney
            initialData={meta.representative}
            clientId={meta.clientId}
            personId={meta.personId}
          />
        </>
      )}
    </main>
  );
};

export default ClientsFields;
