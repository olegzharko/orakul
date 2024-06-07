import * as React from 'react';
import './index.scss';
import Address from './components/Address';
import NativeAddress from './components/NativeAddress';
import Citizenship from './components/Citizenship';
import Contacts from './components/Contacts';
import Work from './components/Work';
import Fio from './components/Fio';
import Passport from './components/Passport';
import Statement from './components/Statement';
import PowerOfAttorney from './components/PowerOfAttorney';
import Termination from './components/Termination';

import { useClientsFields } from './useClientsFields';

const ClientsFields = () => {
  const meta = useClientsFields();

  // console.log('meta.address', meta.address);
  console.log('meta.native_address', meta.native_address);
  return (
    <main className="clients">
      <Fio initialData={meta.fioData} id={meta.personId} />
      <Contacts initialData={meta.contacts} id={meta.personId} />
      <Work initialData={meta.work} id={meta.personId} />
      <Citizenship initialData={meta.citizenship} id={meta.personId} />
      <NativeAddress initialData={meta.native_address} id={meta.personId} />
      <Passport initialData={meta.passport} id={meta.personId} />
      <Address initialData={meta.address} id={meta.personId} />

      {meta.userType === 'client' && (
        <>
          <Statement
            initialData={meta.consents}
            lineItemId={meta.lineItemId}
            personId={meta.personId}
          />
          <PowerOfAttorney
            initialData={meta.representative}
            lineItemId={meta.lineItemId}
            personId={meta.personId}
          />
          <Termination
            initialData={meta.termination}
            lineItemId={meta.lineItemId}
            personId={meta.personId}
          />
        </>
      )}
    </main>
  );
};

export default ClientsFields;
