import * as React from 'react';
import Loader from '../../../../../../../../../../components/Loader/Loader';
import Participants from './components/Participants';
import Persons from './components/Persons';
import { useManagerMain } from './useManagerMain';

const ManagerMain = () => {
  const meta = useManagerMain();

  if (meta.isLoading) {
    return <Loader />;
  }

  return (
    <main className="main">
      <div className="dashboard-header section-title">{meta.mainTitle}</div>
      <Participants initialData={meta.participantsData} cardId={meta.id} />
      <Persons
        initialData={meta.personsData}
        contact_person_type={meta.data?.contact_person_type}
        cardId={meta.id}
      />
    </main>
  );
};

export default ManagerMain;
