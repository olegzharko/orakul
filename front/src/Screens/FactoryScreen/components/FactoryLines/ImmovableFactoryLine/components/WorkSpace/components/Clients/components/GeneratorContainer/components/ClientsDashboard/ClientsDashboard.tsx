import * as React from 'react';
import { v4 as uuidv4 } from 'uuid';

import Card from '../../../../../../../../../../../../../components/Card';
import Loader from '../../../../../../../../../../../../../components/Loader/Loader';
import routes from '../../../../../../../../../../../../../routes';

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
        <div className="clients__colorful-title blue">Покупець</div>
        <div className="clients__colorful-title yellow">Подружжя</div>
        <div className="clients__colorful-title green">Представник</div>
      </div>

      {meta.clients.map((client: any) => (
        <div className="grid" key={uuidv4()}>
          {Object.values(client).map((person: any) => {
            if (!person) return <div />;

            return (
              <Card
                key={person.id}
                title={person.full_name}
                onClick={
                  () => meta.onCardClick(
                    routes.factory.lines.immovable.sections.clients.clientView.linkTo(
                      meta.lineItemId, person.id
                    )
                  )
                }
              >
                {(person.list || []).map((item: any) => (
                  <span>{item}</span>
                ))}
              </Card>
            );
          })}
        </div>
      ))}

      {/* <ConfirmDialog
        open={meta.showModal}
        title="Видалення клієнта"
        message="Ви впевнені, що бажаєте видалити даного клієнта"
        handleClose={() => meta.onModalCancel()}
        handleConfirm={() => meta.onModalConfirm()}
      /> */}
    </main>
  );
};

export default ClientsDashboard;
