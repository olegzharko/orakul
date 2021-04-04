import * as React from 'react';
import { useParams } from 'react-router-dom';
import CardWithClose from '../../../../../../../../../../../../components/CardWithClose';
import './index.scss';

const ClientsDashboard = () => {
  const { id } = useParams<{ id: string }>();
  return (
    <main className="clients">
      <div className="grid mb20">
        <div className="clients__colorful-title blue">Клієнт</div>
        <div className="clients__colorful-title yellow">Подружжя</div>
        <div className="clients__colorful-title green">Представник</div>
      </div>

      <div className="grid">
        <CardWithClose
          title="Жарко Олег Володимирович"
          onClick={() => console.log('click')}
          link={`/${id}/clients/1`}
        >
          <span>1. Паспорт</span>
          <span>1. Паспорт</span>
          <span>1. Паспорт</span>
        </CardWithClose>

        <CardWithClose
          title="Жарко Олег Володимирович"
          onClick={() => console.log('click')}
          link={`/${id}/clients/1`}
        >
          <span>1. Паспорт</span>
          <span>1. Паспорт</span>
          <span>1. Паспорт</span>
        </CardWithClose>

        <CardWithClose
          title="Жарко Олег Володимирович"
          onClick={() => console.log('click')}
          link={`/${id}/clients/1`}
        >
          <span>1. Паспорт</span>
          <span>1. Паспорт</span>
          <span>1. Паспорт</span>
        </CardWithClose>

        <CardWithClose
          title="Жарко Олег Володимирович"
          onClick={() => console.log('click')}
          link={`/${id}/clients/1`}
        >
          <span>1. Паспорт</span>
          <span>1. Паспорт</span>
          <span>1. Паспорт</span>
        </CardWithClose>
      </div>
    </main>
  );
};

export default ClientsDashboard;
