import * as React from 'react';
import { useParams } from 'react-router-dom';
import CardWithClose from '../../../../../../../../../../../../components/CardWithClose';

const ImmovableDashboard = () => {
  const { id } = useParams<{ id: string }>();

  return (
    <div className="immovable__dashboard">
      <div className="immovable__dashboard-header section-title">Нерухомість</div>
      <div className="grid">
        <CardWithClose
          title="Жарко Олег Володимирович"
          onClick={() => console.log('click')}
          link={`/immovables/${id}/1`}
        >
          <span>1. Паспорт</span>
          <span>1. Паспорт</span>
          <span>1. Паспорт</span>
        </CardWithClose>

        <CardWithClose
          title="Жарко Олег Володимирович"
          onClick={() => console.log('click')}
          link={`/immovables/${id}/1`}
        >
          <span>1. Паспорт</span>
          <span>1. Паспорт</span>
          <span>1. Паспорт</span>
        </CardWithClose>
      </div>
    </div>
  );
};

export default ImmovableDashboard;
