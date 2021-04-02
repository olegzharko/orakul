import { DashboardContractNavigation } from '../../../../useDashboardScreen';

export type Props = {
  selectedNav?: DashboardContractNavigation;
  id: string;
}

export const useWorkSpace = ({ selectedNav, id }: Props) => {
  console.log(selectedNav, id);
};
