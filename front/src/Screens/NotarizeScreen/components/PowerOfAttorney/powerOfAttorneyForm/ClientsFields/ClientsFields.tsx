import * as React from 'react';
import './index.scss';
import Address from './components/Address';
import NativeAddress from './components/NativeAddress';
import Citizenship from './components/Citizenship';
import Contacts from './components/Contacts';
import Work from './components/Work';
import Fio from './components/Fio';
import Passport from './components/Passport';

import { useClientsFields } from './useClientsFields';

// Определите интерфейс для типов props
interface ClientsFieldsProps {
  headerColor: string; // clienColor необязательное свойство
  clientType: string;
}

const ClientsFields = ({ headerColor, clientType }: ClientsFieldsProps) => {
  const meta = useClientsFields({ clientType });
  return (
    <main className="clients">
      <Fio
        initialData={meta.fioData}
        headerColor={headerColor}
        clientType={clientType}
      />
      {/* <Contacts initialData={meta.contacts} id={meta.personId} /> */}
      {/* <Work initialData={meta.work} id={meta.personId} /> */}
      <Citizenship
        initialData={meta.citizenship}
        headerColor={headerColor}
        clientType={clientType}
      />
      {/* <NativeAddress initialData={meta.native_address} id={meta.personId} /> */}
      <Passport
        initialData={meta.passport}
        headerColor={headerColor}
        clientType={clientType}
      />
      <Address
        initialData={meta.address}
        headerColor={headerColor}
        clientType={clientType}
      />
    </main>
  );
};

export default ClientsFields;
