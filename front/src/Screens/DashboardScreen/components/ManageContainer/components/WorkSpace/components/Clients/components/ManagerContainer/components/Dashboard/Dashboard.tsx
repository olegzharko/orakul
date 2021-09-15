import * as React from 'react';
import { Link } from 'react-router-dom';

import CardWithClose from '../../../../../../../../../../../../components/CardWithClose';
import ConfirmDialog from '../../../../../../../../../../../../components/ConfirmDialog';
import Loader from '../../../../../../../../../../../../components/Loader/Loader';

import { MANAGE_CONTAINER_LINK_PREFIX } from '../../../../../../../../../../constants';

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
        {(meta.clients || []).map((person: any) => (
          <CardWithClose
            key={person.id}
            title={person.full_name}
            onClick={() => meta.onModalShow(person.id.toString())}
            link={`${MANAGE_CONTAINER_LINK_PREFIX}/clients/${meta.id}/${person.id}`}
          >
            {(person.list || []).map((item: any) => (
              <span>{item}</span>
            ))}
          </CardWithClose>
        ))}

        <Link to={`${MANAGE_CONTAINER_LINK_PREFIX}/clients/${meta.id}/create`} className="add-item-card">
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
