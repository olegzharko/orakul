import * as React from 'react';
import { Link } from 'react-router-dom';

import CardWithClose from '../../../../../../../../../../../../../components/CardWithClose';
import ConfirmDialog from '../../../../../../../../../../../../../components/ConfirmDialog';
import Loader from '../../../../../../../../../../../../../components/Loader/Loader';
import routes from '../../../../../../../../../../../../../routes';

import './index.scss';
import { useDashboard } from './useDashboard';

const Dashboard = () => {
  const meta = useDashboard();

  if (meta.isLoading) {
    return <Loader />;
  }

  return (
    <main className="clients">
      <div className="dashboard-header section-title">Клієнти</div>

      <div className="grid">
        {(meta.mappedClients || []).map((person: any) => (
          <CardWithClose
            key={person.id}
            title={person.full_name}
            onRemove={person.onRemove}
            onClick={person.onClick}
          >
            {(person.list || []).map((item: any) => (
              <span>{item}</span>
            ))}
          </CardWithClose>
        ))}

        <Link to={routes.factory.lines.immovable.sections.clients.clientCreate.linkTo(meta.lineItemId)} className="add-item-card">
          <img src="/images/plus-big.svg" alt="create" />
        </Link>
      </div>

      <ConfirmDialog
        open={meta.showModal}
        title="Видалення клієнта"
        message="Ви впевнені, що бажаєте видалити даного клієнта?"
        handleClose={() => meta.onModalCancel()}
        handleConfirm={() => meta.onModalConfirm()}
      />
    </main>
  );
};

export default Dashboard;
