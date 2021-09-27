import React from 'react';
import CustomSelect from '../../../../../../../components/CustomSelect';

import { ArchiveFilterSelectsProps, useArchiveFilterSelects } from './useArchiveFilterSelects';

const ArchiveFilterSelects = (props: ArchiveFilterSelectsProps) => {
  const meta = useArchiveFilterSelects(props);

  return (
    <div className="filters">
      <span>Сортувати по:</span>

      <div className="filters__select">
        <CustomSelect
          data={meta.contractTypes}
          selectedValue={meta.filterData.contract_type_id}
          onChange={meta.onContractTypeChange}
          label="Тип договору"
        />
      </div>

      <div className="filters__select">
        <CustomSelect
          data={meta.devCompanies}
          selectedValue={meta.filterData.dev_company_id}
          onChange={meta.onDevCompanyChange}
          label="Забудовник"
        />
      </div>

      <div className="filters__select">
        <CustomSelect
          data={meta.devRepresentatives}
          selectedValue={meta.filterData.dev_representative_id}
          onChange={meta.onDevRepresentativeChange}
          label="Підписант"
        />
      </div>
    </div>
  );
};

export default ArchiveFilterSelects;
