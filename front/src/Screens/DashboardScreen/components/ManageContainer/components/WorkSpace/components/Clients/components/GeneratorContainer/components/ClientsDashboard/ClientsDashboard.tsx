import * as React from 'react';
import { v4 as uuidv4 } from 'uuid';
import CardWithClose from '../../../../../../../../../../../../components/CardWithClose';
import ConfirmDialog from '../../../../../../../../../../../../components/ConfirmDialog';
import Loader from '../../../../../../../../../../../../components/Loader/Loader';
import { GenerateClient } from '../../../../../../../../../../../../store/clients/store';
import './index.scss';
import { useClientsDashboard } from './useClientsDashboard';

const ClientsDashboard = () => {
  const meta = useClientsDashboard();

  if (meta.isLoading) {
    return <Loader />;
  }

  return (
    <main className="clients">
      <div className="grid mb20">
        <div className="clients__colorful-title blue">Клієнт</div>
        <div className="clients__colorful-title yellow">Подружжя</div>
        <div className="clients__colorful-title green">Представник</div>
      </div>

      {meta.clients.map((client: GenerateClient) => (
        <div className="grid" key={uuidv4()}>
          {Object.values(client).map((person) => {
            if (!person) return <div />;

            return (
              <CardWithClose
                key={person.id}
                title={person.full_name}
                onClick={() => meta.onModalShow(person.id.toString())}
                link={`/${meta.id}/clients/${person.id}`}
              >
                {person.list.map((item) => (
                  <span>{item}</span>
                ))}
              </CardWithClose>
            );
          })}
        </div>
      ))}
      <ConfirmDialog
        open={meta.showModal}
        title="Видалення клієнта"
        message="Ви впевнені, що бажаєте видалити даного клієнта"
        handleClose={() => meta.onModalCancel()}
        handleConfirm={() => meta.onModalConfirm()}
      />
    </main>
  );
};

export default ClientsDashboard;
