import React from 'react';
import { useParams } from 'react-router-dom'; // Third-party import should come first
import ClientsFields from './ClientsFields'; // Local imports come afterward
import DealFields from './DealFields';

const PowerOfAttorneyForm = () => {
  const { id } = useParams<{ id: string }>();

  return (
    <>
      <h1>Довіритель</h1>
      {/* <ClientsFields headerColor="#8aa6af" clientType="trustor" /> */}
      <h1>Уповноважена особа</h1>
      {/* <ClientsFields headerColor="#a3b89b" clientType="agent" /> */}
      <h1>Предмет довіреності</h1>
      <DealFields />
    </>
  );
};

export default PowerOfAttorneyForm;
