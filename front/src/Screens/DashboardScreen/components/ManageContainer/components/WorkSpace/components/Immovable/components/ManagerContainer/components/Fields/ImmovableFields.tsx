import React from 'react';
import PrimaryButton from '../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../components/SectionWithTitle';
import Checks from './components/Checks/Checks';
import Contract from './components/Contract';
import General from './components/General';
import Responsible from './components/Responsible';
import { useImmovableFields } from './useImmovableFields';

const ImmovableFields = () => {
  const meta = useImmovableFields();

  return (
    <div className="immovable__fields">
      <General
        title=""
        data={meta.general}
        onChange={meta.setGeneral}
        immovableTypes={meta.immovableTypes}
        buildings={meta.buildings}
      />

      <Responsible
        data={meta.responsible}
        reader={meta.reader}
        accompanying={meta.accompanying}
        onChange={meta.setResponsible}
      />

      <Contract
        data={meta.contractType}
        type={[]}
        onChange={meta.setContractType}
      />

      <Checks
        data={meta.checks}
        onChange={meta.setChecks}
      />

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={false} />
      </div>
    </div>
  );
};

export default ImmovableFields;
