import React from 'react';
import ClientsFields from './powerOfAttorneyForm/ClientsFields'; // Local imports come afterward
import DealFields from './powerOfAttorneyForm/DealFields';
import { Props, usePowerOfAttorney } from './usePowerOfAttorney';

const PowerOfAttorney = (props: Props) => {
  const meta = usePowerOfAttorney(props);

  if (!props.powerOfAttorney) {
    return null;
  }

  return (
    <div className="registrator__developer">
      <h1>Довіритель</h1>
      <ClientsFields headerColor="#8aa6af" clientType="trustor" />
      <h1>Уповноважена особа</h1>
      <ClientsFields headerColor="#a3b89b" clientType="agent" />
      <h1>Предмет довіреності</h1>
      <DealFields />
    </div>
  );
};

export default PowerOfAttorney;
