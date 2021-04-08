import * as React from 'react';
import CardWithClose from '../../../../../../../../../../../../components/CardWithClose';
import ConfirmDialog from '../../../../../../../../../../../../components/ConfirmDialog';
import { useImmovableDashboard } from './useImmovableDashboard';

const ImmovableDashboard = () => {
  const meta = useImmovableDashboard();

  return (
    <div className="immovable__dashboard">
      <div className="immovable__dashboard-header section-title">Нерухомість</div>

      <div className="grid">
        {meta.immovables.map((immovable) => (
          <CardWithClose
            key={immovable.id}
            title={immovable.title}
            onClick={() => meta.onModalShow(immovable.id.toString())}
            link={`/immovables/${meta.id}/${immovable.id}`}
          >
            {immovable.list.map((item) => (
              <span>{item}</span>
            ))}
          </CardWithClose>
        ))}
      </div>

      <ConfirmDialog
        open={meta.showModal}
        title="Видалення нерухомості"
        message="Ви впевнені, що бажаєте видалити дану нерухомість"
        handleClose={() => meta.onModalCancel()}
        handleConfirm={() => meta.onModalConfirm()}
      />
    </div>
  );
};

export default ImmovableDashboard;
