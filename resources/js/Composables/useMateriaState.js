import { ref } from 'vue';

// Estado global compartilhado
const materiaId = ref(null);
const materiaDados = ref(null);

export function useMateriaState() {
  const setMateriaId = (id) => {
    materiaId.value = id;
    console.log('Matéria ID memorizado:', id);
  };

  const getMateriaId = () => {
    return materiaId.value;
  };

  const clearMateriaId = () => {
    materiaId.value = null;
    materiaDados.value = null;
  };

  const setMateriaDados = (dados) => {
    materiaDados.value = dados;
    if (dados?.id) {
      materiaId.value = dados.id;
    }
  };

  const getMateriaDados = () => {
    return materiaDados.value;
  };

  return {
    materiaId,
    materiaDados,
    setMateriaId,
    getMateriaId,
    clearMateriaId,
    setMateriaDados,
    getMateriaDados
  };
}
